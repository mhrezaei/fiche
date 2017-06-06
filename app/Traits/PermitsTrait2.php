<?php
namespace App\Traits;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


trait PermitsTrait2
{
	protected static $wildcards         = ['', 'any', '*'];
	protected static $default_role      = 'admin';
	protected static $available_permits = ['browse', 'process', 'view', 'send', 'search', 'create', 'edit', 'publish', 'activate', 'report', 'delete', 'bin'];
	protected static $coder             = '~jFCQ?U0y&rvYp8<b9{Ew[V#N;7tx,M51]L(Bq@!^fa|2Z}XgD+lT4Ie>sJmP.huod:*Kkz3nHR-G_f)6iW%cAOS';
	protected static $alpha             = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMfNOPQRSTUVWXYZ1234567890-!@#%^&*()_+~[]|;,.{}:<>?';
	protected        $stored_roles      = false;
	protected        $as                = null;
	protected        $as_all            = false;
	protected        $include_disabled  = false;
	protected        $min_status        = false;
	protected        $max_status        = false;

	/*
	|--------------------------------------------------------------------------
	| Background Factory
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Laravel standard many to many relation method.
	 * @return Model
	 */
	public function roles()
	{
		return $this->belongsToMany('App\Models\Role')->withPivot('permissions', 'status', 'deleted_at', 'key')->withTimestamps();
	}

	/**
	 * Gets array of roles from either database or if possible from the session.
	 * @return \Illuminate\Support\Collection
	 */
	private function getRoles()
	{
		if(user()->id == $this->id) {
			$revealed_at = session()->get('logged_user_revealed_at', false);
			$roles       = session()->get('logged_user_roles', false);
			if(!$roles or !$revealed_at or $revealed_at < $this->updated_at) {
				$roles = $this->fetchRoles();
				session()->put('logged_user_roles', $roles);
				session()->put('logged_user_revealed_at', Carbon::now()->toDateTimeString());
			}
			$this->stored_roles = $roles;
		}
		elseif($this->stored_roles) {
			$roles = $this->stored_roles;
		}
		else {
			$this->stored_roles = $roles = $this->fetchRoles();
		}


		return $roles;
	}

	/**
	 * Gets a fresh list of roles, adds the virtual default role, and removes all illegally modified ones.
	 * @return \Illuminate\Support\Collection
	 */
	private function fetchRoles() // <-- (From Database)
	{
		$default_role = Role::findBySlug(self::defaultRole());
		$roles_array  = $this->roles()->get()->toArray();

		$roles_array[] = [
			'id'    => $default_role->id,
			'slug'  => $default_role->slug,
			'title' => $default_role->title,
			'pivot' => [
				'user_id'     => $this->id,
				'role_id'     => $default_role->id,
				'status'      => $this->status,
				'permissions' => '',
				'key'         => $this->meta('key'), // <~~ RISKY :D
				'deleted_at'  => $this->meta('default_role_deleted_at'),
			],
		];

		foreach($roles_array as $key => $role_row) {
			$role_row['pivot']['permissions'] = self::adorn($role_row['pivot']['permissions']);
			if(!$this->checkKey($role_row)) {
				unset($roles_array[ $key ]);
				//$roles_array[ $key ]['NOT_VALID'] = 1;
			}
			else {
				$roles_array[ $key ] = $role_row;
			}
		}

		return collect($roles_array);
	}

	/**
	 * Gets a variable from the trait chain-holder properties and resets it to the false afterwards.
	 *
	 * @param $variable
	 *
	 * @return mixed
	 */
	private function getChain($variable)
	{
		$return          = $this->$variable;
		$this->$variable = false;

		return $return;
	}

	/**
	 * Mixes all available permissions, considering the requested role via $this->rolesQuery() and disabled roles via the chain methods.
	 * @return string
	 */
	private function rolesPermits()
	{
		return implode(' ', $this->rolesQuery()->pluck('pivot.permissions')->toArray());
	}

	/**
	 * Runs a query through the available collection, considering all the Chain property limitations.
	 * @return \Illuminate\Support\Collection|static
	 */
	public function rolesQuery()
	{
		/*-----------------------------------------------
		| Parameters ...
		*/
		$include_disabled = $this->getChain('include_disabled');
		$min_status       = $this->getChain('min_status');
		$max_status       = $this->getChain('max_status');
		$request_roles    = $this->getChain('as');

		if($min_status === false) {
			$min_status = 1;
		}

		if($request_roles and !is_array($request_roles)) {
			$request_roles = [$request_roles];
		}

		/*-----------------------------------------------
		| Query Buildup ...
		*/
		$query = $this->getRoles();

		if($request_roles) {
			$query = $query->whereIn('slug', $request_roles);
		}
		if($min_status) {
			$query = $query->where('pivot.status', '>=', $min_status);
		}
		if($max_status) {
			$query = $query->where('pivot.status', '<=', $max_status);
		}
		if(!$include_disabled) {
			$query = $query->where('pivot.deleted_at', null);
		}

		/*-----------------------------------------------
		| Return ...
		*/

		return $query;

	}

	/**
	 * defacing of the permissions string
	 *
	 * @param $text
	 *
	 * @return string
	 */
	private static function deface($text)
	{
		return strtr($text, self::$alpha, self::$coder);
	}

	/**
	 * Reverting the defaced permissions string to its original state
	 *
	 * @param $text
	 *
	 * @return string
	 */
	private static function adorn($text)
	{
		return strtr($text, self::$coder, self::$alpha);
	}

	/**
	 * Generates and md5 hash key of all the vital authorization-concerned properties.
	 *
	 * @param $role_id
	 * @param $permissions
	 * @param $status
	 * @param $deleted_at
	 *
	 * @return string
	 */
	private function makeKey($role_id, $permissions, $status, $deleted_at)
	{
		$lock_string = $this->keyFactory(
			$role_id,
			$permissions,
			$status,
			$deleted_at
		);
		//ss($lock_string);
		//ss('---------------------------');

		return md5($lock_string);
	}

	/**
	 * Checks if the hash key of a given role_row is matched with its content.
	 *
	 * @param $role_row
	 *
	 * @return bool
	 */
	private function checkKey($role_row)
	{
		$lock_string = $this->keyFactory(
			$role_row['id'],
			$role_row['pivot']['permissions'],
			$role_row['pivot']['status'],
			$role_row['pivot']['deleted_at']
		);

		return boolval(md5($lock_string) == $role_row['pivot']['key']);
	}

	/**
	 * Normalizes all the authorisation-concerned properties into a single standard.
	 *
	 * @param $role_id
	 * @param $permissions
	 * @param $status
	 * @param $deleted_at
	 *
	 * @return bool|string
	 */
	private function keyFactory($role_id, $permissions, $status, $deleted_at)
	{
		if(!$this->id) {
			return false;
		}
		if(!$role_id or !is_numeric($role_id)) {
			return false;
		}
		if(!$permissions) {
			$permissions = '';
		}
		$status = intval($status);
		if(!$deleted_at) {
			$deleted_at = null;
		}

		$lock_array = [
			'user_id'     => $this->id,
			'role_id'     => $role_id,
			'permissions' => $permissions,
			'status'      => $status,
			'deleted_at'  => $deleted_at,
		];

		return json_encode($lock_array);

	}

	/**
	 * Updates the main User row, so that the `updated_at` can be used to check if the session cache is expired.
	 * @return $this
	 */
	private function fakeUpdate()
	{
		$this->updated_at = Carbon::now()->toDateTimeString();
		$this->update();

		$this->stored_roles = false ;
		return $this;
	}

	/*
	|--------------------------------------------------------------------------
	| Assignments
	|--------------------------------------------------------------------------
	|
	*/
	/**
	 * Replaces the permissions of a single role with the given ones.
	 * Role must be passed via the chain method as(). multiple choices and default one are not allowed herein.
	 *
	 * @param $permissions
	 *
	 * @return $this|bool
	 */
	public function setPermission($permissions)
	{
		$as = $this->getChain('as');
		if($as == self::defaultRole() or !$as) {
			return false;
		}

		$current_row = $this->as($as)->withDisabled()->rolesQuery()->first();
		$this->roles()->updateExistingPivot($current_row['id'], [
			'permissions' => self::deface($permissions),
			'key'         => $this->makeKey($current_row['id'], $permissions, $current_row['pivot']['status'], $current_row['pivot']['deleted_at']),
		])
		;

		return $this->fakeUpdate();
	}

	/**
	 * Replaces the status of a single role with the given one.
	 * Role must be passed via the cain method as(). Multiple choices are not allowed herein.
	 *
	 * @param $status
	 *
	 * @return $this|bool
	 */
	public function setStatus($status)
	{
		$as          = $this->getChain('as');
		$current_row = $this->as($as)->withDisabled()->rolesQuery()->first();

		if(!$as) {
			return false;
		}
		else {
			if($as == self::defaultRole()) {
				$this->updateMeta([
					'key' => $this->makeKey($current_row['id'], '', $status, $current_row['pivot']['deleted_at']),
				]);
				$this->status = $status;

				return $this->suppressMeta()->save();
			}

			$this->roles()->updateExistingPivot($current_row['id'], [
				'status' => $status,
				'key'    => $this->makeKey($current_row['id'], $current_row['pivot']['permissions'], $status, $current_row['pivot']['deleted_at']),
			])
			;

			return $this->fakeUpdate();
		}
	}

	/**
	 * Disables a single role of a user, using its `deleted_at` property.
	 * Role must be passed via the cain method as(). Multiple choices are not allowed herein.
	 * @return $this|bool
	 */
	public function disableRole()
	{
		$as          = $this->getChain('as');
		$current_row = $this->as($as)->withDisabled()->rolesQuery()->first();
		$now         = Carbon::now()->toDateTimeString();


		if(!$as) {
			return false;
		}
		if(!$current_row['id']) {
			return false;
		}

		if($as == self::defaultRole()) {
			$this->updateMeta([
				'key'                     => $this->makeKey($current_row['id'], '', $current_row['pivot']['status'], $now),
				'default_role_deleted_at' => $now,
			]);

			return $this->suppressMeta()->save();
		}
		else {
			$this->roles()->updateExistingPivot($current_row['id'], [
				'key'        => $this->makeKey($current_row['id'], $current_row['pivot']['permissions'], $current_row['pivot']['status'], $now),
				'deleted_at' => $now,
			])
			;

			return $this->fakeUpdate();
		}

	}

	/**
	 * Enables a single role of a user, using its `deleted_at` property.
	 * Role must be passed via the cain method as(). Multiple choices are not allowed herein.
	 * @return $this|bool
	 */
	public function enableRole()
	{
		$as          = $this->getChain('as');
		$current_row = $this->as($as)->withDisabled()->rolesQuery()->first();
		if(!$as or !$current_row['id']) {
			return false;
		}

		if($as == self::defaultRole()) {
			$this->updateMeta([
				'key'                     => $this->makeKey($current_row['id'], '', $current_row['pivot']['status'], ''),
				'default_role_deleted_at' => '',
			]);

			return $this->suppressMeta()->save();
		}
		else {
			$this->roles()->updateExistingPivot($current_row['id'], [
				'key'        => $this->makeKey($current_row['id'], $current_row['pivot']['permissions'], $current_row['pivot']['status'], null),
				'deleted_at' => null,
			])
			;

			return $this->fakeUpdate();
		}

	}

	/**
	 * Attaches a single role to a user, via the attacheRoles() method. Any already existing role will be overridden.
	 *
	 * @param        $role_slug
	 * @param string $permissions
	 * @param int    $status
	 *
	 * @return $this|bool
	 */
	public function attachRole($role_slug, $permissions = '', $status = 1)
	{
		return $this->attachRoles([
			[
				'role'        => $role_slug,
				'permissions' => $permissions,
				'status'      => $status,
			],
		]);
	}

	/**
	 * Attaches a number of roles to a user. Any already existing role will be overridden.
	 *
	 * @param $roles_and_permissions_array : use the pattern on attachRole to make a proper array. :D
	 *
	 * @return $this|bool
	 */
	public function attachRoles($roles_and_permissions_array)
	{
		$return = false;

		foreach($roles_and_permissions_array as $item) {
			$role = Role::findBySlug($item['role']);
			if(!$role or !$role->exists) {
				continue;
			}
			$item = array_normalize($item, [
				'permissions' => '',
				'status'      => "1",
			]);
			$key  = $this->makeKey($role->id, $item['permissions'], $item['status'], '');


			if($role->slug == self::defaultRole()) {
				$this->updateMeta([
					'key'                     => $key,
					'default_role_deleted_at' => '',
				]);
				$this->status = $item['status'];
				$return       = $this->suppressMeta()->save();
			}
			else {
				$this->roles()->detach($role->id);
				$this->roles()->attach($role->id, [
					'permissions' => self::deface($item['permissions']),
					'status'      => $item['status'],
					'key'         => $key,
					'deleted_at'  => null,
				])
				;
				$return = $this->fakeUpdate();
			}
		}

		return $return;
	}

	/**
	 * Detaches all the user roles, except the one marked as default role found by $this->defaultRole()
	 */
	public function detachAll()
	{
		$this->roles()->detach();
	}

	/**
	 * Detaches a single user role, via $this->detachRoles()
	 *
	 * @param $role_slug
	 *
	 * @return $this|bool
	 */
	public function detachRole($role_slug)
	{
		return $this->detachRoles([$role_slug]);
	}

	/**
	 * Detaches a number of user roles, neglecting the default role
	 *
	 * @param $role_slugs_array
	 *
	 * @return $this|bool
	 */
	public function detachRoles($role_slugs_array)
	{
		$return = false;
		foreach($role_slugs_array as $role_slug) {
			$role = Role::findBySlug($role_slug);
			if(!$role) {
				continue;
			}

			if($role_slug == self::defaultRole()) {
				$this->updateMeta([
					'key' => false,
				]);
				$this->status = 0;
				$return       = $this->suppressMeta()->save();
			}
			else {
				$this->roles()->detach($role->id);
				$return = $this->fakeUpdate();
			}


		}

		return $return;
	}


	/*
	|--------------------------------------------------------------------------
	| Usage Hooks
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * @return array: of all the available roles.
	 * Utilizing the chain methods before calling this method are supported.
	 */
	public function rolesArray()
	{
		return $this->rolesQuery()->pluck('slug')->toArray();
	}


	/**
	 * Checks if the current user as the requested role(s)
	 *
	 * @param null $request
	 * @param bool $any_of_them
	 *
	 * @return bool
	 */
	public function hasRole($request = null, $any_of_them = false)
	{
		/*-----------------------------------------------
		| Variable Setup ...
		*/
		if($request) {
			$this->as($request);
		}
		else {
			$request = $this->as;
		}

		/*-----------------------------------------------
		| Shortcuts ...
		*/
		if(in_array($request, ['developer', 'dev'])) {
			return $this->isDeveloper();
		}
		if($request == 'superadmin') {
			return $this->as('admin')->isSuper();
		}

		/*-----------------------------------------------
		| Simple Decisions ...
		*/
		if(!$this->exists) {
			return false;
		}
		if($this->id == user()->id and $this->isDeveloper()) {
			return true;
		}

		/*-----------------------------------------------
		| Final Decision ...
		*/
		$count = $this->rolesQuery()->count();

		if($any_of_them) {
			return boolval($count);
		}
		else {
			return boolval($count == count($request));
		}

	}

	/**
	 * @return bool
	 */
	public function isDeveloper()
	{
		return in_array($this->code_melli, ['0074715623', '0012071110', '0017263573']);
	}

	/**
	 * @return bool
	 */
	public function isSuper()
	{

		$role = $this->getChain('as');
		if($role) {
			return $this->as($role)->can('super');
		}
		else {
			return $this->as('admin')->can('super'); //@TODO: Suspicous Result!
		}
	}

	/**
	 * @param string $request : the permission in ask. Accepts only one request at a time.
	 * @param bool   $blah : Just kept to be compatible with the native Eloquent can()
	 *
	 * @return bool
	 */
	public function can($request = '*', $blah = false)
	{
		/*-----------------------------------------------
		| Parameters ...
		*/
		$request = str_replace('post-', 'posts-', $request);
		$request = str_replace('comment-', 'comments-', $request);
		$request = str_replace('user-', 'users-', $request);
		if(in_array($request, self::$wildcards)) {
			$request = null;
		}
		foreach(self::$wildcards as $wildcard) {
			$request = str_replace($wildcard, '', $request);
		}

		/*-----------------------------------------------
		| Simple Decisions ...
		*/
		if($request == 'developer' or $request == 'dev') {
			return $this->isDeveloper();
		}
		if($request == 'super' or $request == 'superadmin') {
			$request = 'users-admin'; //@TODO: Find a better solution!
		}
		if(!$this->exists) {
			return false;
		}
		if($this->isDeveloper()) {
			return true;
		}
		if(!$this->as and !$this->as_all) {
			return false;
		}

		/*-----------------------------------------------
		| Final Decisions ...
		*/

		return str_contains($this->rolesPermits(), $request);
	}


	/**
	 * finds out the default role slug via the settings system
	 *
	 * @param bool $use_cache
	 *
	 * @return string
	 */
	public static function defaultRole($use_cache = true)
	{
		if($use_cache) {
			return setting()->ask('default_role')->gain();
		}
		else {
			return setting()->ask('default_role')->noCache()->gain();
		}
	}


	/**
	 * Checks if the user in the given role (through the $this->as() chain method) is enabled.
	 *
	 * @return bool
	 */
	public function enabled()
	{
		$as          = $this->getChain('as');
		$current_row = $this->as($as)->withDisabled()->rolesQuery()->first();

		if(!$as) {
			return false;
		}
		else {
			return !boolval($current_row['pivot']['deleted_at']);
		}
	}

	/**
	 * Uses the role passed from chain method $this->as() to return the status of a given role.
	 * @return integer
	 */
	public function getStatus()
	{
		return $this->withDisabled()->rolesQuery()->first()['pivot']['status'];
	}

	/**
	 * Uses the role passed from chain method $this->as() to return the title of a given role.
	 * @return string
	 */
	public function getTitle()
	{
		return $this->withDisabled()->rolesQuery()->first()['title'];
	}

	/*
	|--------------------------------------------------------------------------
	| Chain Methods
	|--------------------------------------------------------------------------
	|
	*/

	/**
	 * Sets the necessary flag to include disabled roles in $this->roleQuery().
	 *
	 * @return $this
	 */
	public function includeDisabled()
	{
		$this->include_disabled = true;

		return $this;
	}

	/**
	 * Mirror of $this->includeDisabled()
	 * Sets the necessary flag to include disabled roles in $this->roleQuery().
	 *
	 * @return $this
	 */
	public function withDisabled()
	{
		return $this->includeDisabled();
	}


	/**
	 * Sets the necessary flag to take one of the roles in $this->roleQuery().
	 *
	 * @param $requested_role : string|array
	 *  'all' can be passed to set the as_all flag, used in $this->can() to prevent accidental call of all roles.
	 *  'manager' can be passed to set an array of roles provided by Role::adminRoles()
	 *
	 * @return $this
	 */
	public function as ($requested_role)
	{
		if($requested_role == 'all') {
			$this->as     = false;
			$this->as_all = true;
		}
		elseif($requested_role == 'admin') {
			$this->as = Role::adminRoles();
		}
		else {
			$this->as = $requested_role;
		}

		return $this;
	}


	/**
	 * Sets the necessary flag to consider a minimum status in $this->roleQuery().
	 *
	 * @param int $min_status
	 *
	 * @return $this
	 */
	public function min($min_status = 1)
	{
		$this->min_status = $min_status;

		return $this;
	}

	/**
	 * Sets the necessary flag to consider a maximum status in $this->roleQuery().
	 *
	 * @param int $max_status
	 *
	 * @return $this
	 */
	public function max($max_status = 1)
	{
		$this->max_status = $max_status;

		return $this;
	}

	/**
	 * Returns nothing! :D (useful in the chain mehtods)
	 * @return null
	 */
	public function shh()
	{
		return null;
	}


	/*
	|--------------------------------------------------------------------------
	| Beautiful Mirrors
	|--------------------------------------------------------------------------
	|
	*/
	/**
	 * A mirror to call $this->hasRole()
	 *
	 * @param $requested_role
	 *
	 * @return bool
	 */
	public function is_a($requested_role)
	{
		return $this->hasRole($requested_role);
	}

	/**
	 * A mirror to call $this->hasRole()
	 *
	 * ∫      * @param $requested_role
	 *
	 * @return bool
	 */
	public function is_an($requested_role)
	{
		return $this->hasRole($requested_role);
	}

	/**
	 * A mirror to call the reverse of $this->hasRole()
	 *
	 * @param $requested_role
	 *
	 * @return bool
	 */
	public function is_not_a($requested_role)
	{
		return !$this->hasRole($requested_role);
	}

	/**
	 * A mirror to call the reverse of $this->hasRole()
	 *
	 * @param $requested_role
	 *
	 * @return bool
	 */
	public function is_not_an($requested_role)
	{
		return !$this->hasRole($requested_role);
	}

	/**
	 * A mirror to call $this->hasRole(), setting the necessary flag to check either of the requests.
	 *
	 * @param $requested_roles : array
	 *
	 * @return bool
	 */
	public function is_one_of($requested_roles)
	{
		return $this->hasRole($requested_roles, true);
	}

	/**
	 * A mirror to call $this->hasRole(), setting the necessary flag to check either of the requests.
	 *
	 * @param $requested_roles : array
	 *
	 * @return bool
	 */
	public function is_any_of($requested_roles)
	{
		return $this->hasRole($requested_roles, true);
	}

	/**
	 * A mirror to call the reverse of $this->hasRole(), setting the necessary flag to check either of the requests.
	 *
	 * @param $requested_roles : array
	 *
	 * @return bool
	 */
	public function is_not_one_of($requested_roles)
	{
		return !$this->hasRole($requested_roles, true);
	}

	/**
	 * A mirror to call the reverse of $this->hasRole(), setting the necessary flag to check all of the requests.
	 *
	 * @param $requested_roles
	 *
	 * @return bool
	 */
	public function is_not_any_of($requested_roles)
	{
		return !$this->hasRole($requested_roles, true);
	}

	/**
	 * A mirror to call $this->hasRole(), setting the necessary flag to check all of the requests.
	 *
	 * @param $requested_roles : array
	 *
	 * @return bool
	 */
	public function is_all_of($requested_roles)
	{
		return $this->hasRole($requested_roles, false);
	}

	/**
	 * A mirror to call the reverse of $this->hasRole(), setting the necessary flag to check all of the requests.
	 *
	 * @param $requested_roles : array
	 *
	 * @return bool
	 */
	public function is_none_of($requested_roles)
	{
		return !$this->hasRole($requested_roles, false);
	}

	/**
	 * A mirror to call the reverse of $this->hasRole(), setting the necessary flag to check all of the requests.
	 *
	 * @param $requested_roles : array
	 *
	 * @return bool
	 */
	public function is_not_all_of($requested_roles)
	{
		return !$this->hasRole($requested_roles, false);
	}

	/**
	 * A mirror to check if the user is attached to one of the 'admin' roles, found by Role::adminRoles()
	 *
	 * @return bool
	 */
	public function is_admin()
	{
		return $this->is_any_of(Role::adminRoles());
	}

	/**
	 * @return bool
	 */
	public function is_superadmin()
	{
		return $this->as('admin')->can('super'); //@TODO: Find a better sollution
	}

	/**
	 * a mirror to call $this->as() chain method, with 'all' parameter automatically set.
	 *
	 * @return $this
	 */
	public function as_all()
	{
		return $this->as('all');
	}

	/**
	 * a mirror to call $this->as() chain method, with 'manager' parameter automatically set.
	 *
	 * @return $this
	 */
	public function as_manager()
	{
		return $this->as('manager');
	}

	/**
	 * a mirror to call $this->as() chain method, with 'all' parameter automatically set.
	 *
	 * @return $this
	 */
	public function as_any()
	{
		return $this->as('all');
	}

	/**
	 * A mirror to call the reverse of $this->can()
	 *
	 * @param string $request
	 * @param bool   $blah : Just kept to be compatible with the native Eloquent can()
	 *
	 * @return bool
	 */
	public function cant($request = '*', $blah = false)
	{
		return !$this->can($request);
	}

	/**
	 * A mirror to call the reverse of $this->can()
	 *
	 * @param string $request
	 * @param bool   $blah : Just kept to be compatible with the native Eloquent can()
	 *
	 * @return bool
	 */
	public function cannot($request = '*', $blah = false)
	{
		return !$this->can($request);
	}

	/**
	 * A mirror to call $this->can() to check all the requests
	 *
	 * @param $requests : array
	 *
	 * @return bool
	 */
	public function can_all($requests)
	{
		foreach($requests as $request) {
			if($this->cannot($request)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * A mirror to call $this->can() to check any of the given requests.
	 *
	 * @param $requests : array
	 *
	 * @return bool
	 */
	public function can_any($requests)
	{
		foreach($requests as $request) {
			if($this->can($request)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * A mirror to call the reverse of $this->as('folan')->enabled()
	 *
	 * @return bool
	 */
	public function disabled()
	{
		return !$this->enabled();
	}


	/**
	 * A mirror to call $this->disableRole()
	 */
	public function disable()
	{
		$this->disableRole();
	}

	/**
	 * A mirror to call $this->enableRole()
	 */
	public function enable()
	{
		$this->enableRole();
	}

	/**
	 * A mirror to call $this->getStatus()
	 *
	 * @return int
	 */
	public function status()
	{
		return $this->getStatus();
	}

	/**
	 * A mirror to call $this->getTitle()
	 * @return string
	 */
	public function title()
	{
		return $this->getTitle();
	}


}