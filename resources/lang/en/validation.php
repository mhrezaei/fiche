<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	'captcha'         => 'Invalid Captcha',
	'invalid'         => 'Invalid Request',
	'phone'           => 'Invalid :attribute',
	'code_melli'      => "Invalid :attribute ",
	'forbidden_chars' => "Unallowable Characters in :attribute",
	'required_chars'  => "Some required characters don't exist in :attribute",
	'time'            => "Invalid :attribute",
	'shetab'          => "Invalid :attribute",
	'national_id'     => "Invalid :attribute",
	'postal_code'     => "Invalid :attribute",
	'sheba'           => "Invalid :attribute",

	'accepted'             => 'The :attribute must be accepted.',
	'active_url'           => 'The :attribute is not a valid URL.',
	'after'                => 'The :attribute must be a date after :date.',
	'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
	'alpha'                => 'The :attribute may only contain letters.',
	'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
	'alpha_num'            => 'The :attribute may only contain letters and numbers.',
	'array'                => 'The :attribute must be an array.',
	'before'               => 'The :attribute must be a date before :date.',
	'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
	'between'              => [
		'numeric' => 'The :attribute must be between :min and :max.',
		'file'    => 'The :attribute must be between :min and :max kilobytes.',
		'string'  => 'The :attribute must be between :min and :max characters.',
		'array'   => 'The :attribute must have between :min and :max items.',
	],
	'boolean'              => 'The :attribute field must be true or false.',
	'confirmed'            => 'The :attribute confirmation does not match.',
	'date'                 => 'The :attribute is not a valid date.',
	'date_format'          => 'The :attribute does not match the format :format.',
	'different'            => 'The :attribute and :other must be different.',
	'digits'               => 'The :attribute must be :digits digits.',
	'digits_between'       => 'The :attribute must be between :min and :max digits.',
	'dimensions'           => 'The :attribute has invalid image dimensions.',
	'distinct'             => 'The :attribute field has a duplicate value.',
	'email'                => 'The :attribute must be a valid email address.',
	'exists'               => 'The selected :attribute is invalid.',
	'file'                 => 'The :attribute must be a file.',
	'filled'               => 'The :attribute field is required.',
	'image'                => 'The :attribute must be an image.',
	'in'                   => 'The selected :attribute is invalid.',
	'in_array'             => 'The :attribute field does not exist in :other.',
	'integer'              => 'The :attribute must be an integer.',
	'ip'                   => 'The :attribute must be a valid IP address.',
	'json'                 => 'The :attribute must be a valid JSON string.',
	'max'                  => [
		'numeric' => 'The :attribute may not be greater than :max.',
		'file'    => 'The :attribute may not be greater than :max kilobytes.',
		'string'  => 'The :attribute may not be greater than :max characters.',
		'array'   => 'The :attribute may not have more than :max items.',
	],
	'mimes'                => 'The :attribute must be a file of type: :values.',
	'mimetypes'            => 'The :attribute must be a file of type: :values.',
	'min'                  => [
		'numeric' => 'The :attribute must be at least :min.',
		'file'    => 'The :attribute must be at least :min kilobytes.',
		'string'  => 'The :attribute must be at least :min characters.',
		'array'   => 'The :attribute must have at least :min items.',
	],
	'not_in'               => 'The selected :attribute is invalid.',
	'numeric'              => 'The :attribute must be a number.',
	'present'              => 'The :attribute field must be present.',
	'regex'                => 'The :attribute format is invalid.',
	'required'             => 'The :attribute field is required.',
	'required_if'          => 'The :attribute field is required when :other is :value.',
	'required_unless'      => 'The :attribute field is required unless :other is in :values.',
	'required_with'        => 'The :attribute field is required when :values is present.',
	'required_with_all'    => 'The :attribute field is required when :values is present.',
	'required_without'     => 'The :attribute field is required when :values is not present.',
	'required_without_all' => 'The :attribute field is required when none of :values are present.',
	'same'                 => 'The :attribute and :other must match.',
	'size'                 => [
		'numeric' => 'The :attribute must be :size.',
		'file'    => 'The :attribute must be :size kilobytes.',
		'string'  => 'The :attribute must be :size characters.',
		'array'   => 'The :attribute must contain :size items.',
	],
	'string'               => 'The :attribute must be a string.',
	'timezone'             => 'The :attribute must be a valid zone.',
	'unique'               => 'The :attribute has already been taken.',
	'uploaded'             => 'The :attribute failed to upload.',
	'url'                  => 'The :attribute format is invalid.',
	"auth.fail"            => "Username or Password is invalid.",
	"search"               => "جست‌وجو بی‌نتیجه بود.",
	"persian"              => ":attribute را با حروف فارسی تکمیل نمایید.",
	'english'              => ":attribute را با کاراکترهای انگلیسی تکمیل نمایید.",
	'slug'                 => "تنها حروف و اعداد انگلیسی، به همراه - و ـ در :attribute مجاز هستند و اعداد نباید در ابتدا باشند.",
	"file_exists"          => "فایل :attribute وجود ندارد یا پاک شده است.",


	'javascript_validation' => [
		"email"                => "Enter valid email.",
		"username"             => "Enter valid username.",
		"security"             => "Enter valid security code.",
		"password"             => "Enter password with at least 8 characters.",
		"password2"            => "Passwords are not matched together.",
		"new_password"         => "Enter new password with at least 8 characters.",
		"new_password2"        => "New passwords are not matched together.",
		"birthday"             => "Enter valid birthday.",
		"name_first"           => "Enter name with english characters.",
		"name_last"            => "Enter last name with english characters.",
		"name_father"          => "Enter father name with english characters.",
		"code_melli"           => "Enter 10 digits national id.",
		"code_id"              => "Enter valid ID.",
		"gender"               => "Select gender.",
		"birth_date"           => "Enter valid birth date.",
		"marriage_date"        => "Enter valid marriage date.",
		"birth_city"           => "Enter birth city with english characters.",
		"marital_status"       => "Select marital status.",
		"occupation"           => "Select occupation.",
		"education"            => "Select education.",
		"edu_level"            => "Select education level.",
		"edu_field"            => "Enter education field with english characters.",
		'edu_city'             => 'Enter education city with english characters.',
		"mobile"               => 'Enter mobile number in 11 digits.',
		"tel_emergency"        => 'Enter emergency telephone number in 11 digits.',
		"home_city"            => "Select home city.",
		"home_address"         => "Enter home address with english characters.",
		"home_tel"             => "Enter home telephone number in 11 digits.",
		"work_city"            => "Select work city.",
		"work_address"         => "Enter work address with english characters.",
		"work_tel"             => "Enter work telephone number in 11 digits.",
		"job"                  => "Enter job title with english characters.",
		"familization"         => "Select familization.",
		"motivation"           => "Enter motivation with english characters.",
		"alloc_time"           => "Enter allocation time.",
		'title'                => 'Enter title.',
		'slug'                 => 'Enter slug.',
		'cities'               => 'Select cities',
		'organs'               => 'Select at least one organ.',
		'term_of_service'      => 'You didn\'t accept terms and conditions.',
		'password_reset_token' => 'Enter reset password token.',
	],

	'attributes_example' => [
		"email"            => "Example: site@site.com",
		"username"         => "Example: mohammadahmadi",
		"password"         => "********",
		"password2"        => "********",
		"security"         => "Example: 15",
		"name_first"       => "Example: Mohamad",
		"name_last"        => "Example: Ahmadi",
		"name_father"      => "Example: Ali",
		"code_melli"       => "Example: 1234567890",
		"code_id"          => "Example: 456",
		"gender"           => "Example: Male",
		"birth_date"       => "Example: 1982/03/25",
		"birth_city"       => "Example: Tehran",
		"marital_status"   => "Example: Married",
		"edu_level"        => "Example: Bachelor",
		"edu_field"        => "Example: Mechanical Engineering",
		'edu_city'         => 'Example: Shiraz',
		"mobile"           => 'Example: 09121234567',
		"tel_emergency"    => 'Example: 02122334455',
		"home_city"        => "Example: Tehran",
		"home_address"     => "Example: No 77, Ahmadi St, Darband",
		"home_tel"         => "Example: 02122112211",
		"work_city"        => "Example: Karaj",
		"work_address"     => "No 90, Ajori St, Zamani St",
		"work_tel"         => "02632255213",
		"job"              => "Example: Employee",
		"familization"     => "Example: Site",
		"motivation"       => "Example: Charitable Activities",
		"alloc_time"       => "Example: 5 days",
		"marital"          => 'Example: Married',
		"home_postal_code" => 'Example: 1122334455',
		"work_postal_code" => 'Example: 1122334455',
	],

	'attributes_placeholder' => [
		"email"            => "(English Characters)",
		"username"         => "(English Characters)",
		"password"         => "(حداقل ۸ کاراکتر)",
		"password2"        => "(تکرار گذرواژه)",
		"new_password"     => "(حداقل ۸ کاراکتر)",
		"new_password2"    => "(تکرار گذرواژه‌ی جدید)",
		"security"         => "(فقط عدد)",
		"name_first"       => "(English Characters)",
		"name_last"        => "(English Characters)",
		"name_father"      => "(English Characters)",
		"code_melli"       => "(10 digits with no dash)",
		"code_id"          => "(فقط عدد)",
		"gender"           => "",
		"birth_date"       => '(Select from auto select table or in "year/month/day" format)',
		"marriage_date"    => '(Select from auto select table or in "year/month/day" format)',
		"birth_city"       => "(English Characters)",
		"marital_status"   => "",
		"edu_level"        => "",
		"edu_field"        => "(English Characters)",
		'edu_city'         => '(English Characters)',
		"mobile"           => '(11 digits with no dash)',
		"tel_emergency"    => '(11 digits with no dash)',
		"home_city"        => "(English Characters)",
		"home_address"     => "(English Characters)",
		"address"          => "(English Characters)",
		"home_tel"         => "(11 digits with no dash)",
		"work_city"        => "(English Characters)",
		"work_address"     => "(English Characters)",
		"work_tel"         => "(11 digits with no dash)",
		"job"              => "(English Characters)",
		"familization"     => "",
		"motivation"       => "(English Characters)",
		"alloc_time"       => "(Number of days. Only Numbers)",
		"postal_code"      => "(10 digits with no dash)",
		"home_postal_code" => "(10 digits with no dash)",
		"work_postal_code" => "(10 digits with no dash)",
		"time"             => 'Hour and Minute. In common format "hour:minute". Example 20:42',

		'your_comment'          => 'Your Comment',
		'max_per_page'          => "How many posts should be in a page? Enter the number here. Specifying zero (0) will disable this option.",
		'fresh_time_duration'   => "How much time after publication a post it is fresh? Enter in days.",
		'featured_image_width'  => "Enter width of featured image in pixels.",
		'featured_image_height' => "Enter height of featured image in pixels.",
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [
		'optional_meta' => "Optional Meta",
		'feature_meta'  => "Featured Mera",
		'moderate_note' => "Moderate Note",
		'folder_id'     => "Folder",

		'order'            => "Order",
		'template'         => 'Template',
		"action"           => 'Action',
		"email"            => "Email",
		"username"         => "Username",
		"security"         => "Security Code",
		"current_password" => "Current Password",
		"password"         => "Password",
		"password2"        => "Confirm Password",
		"new_password"     => "New Password",
		"new_password2"    => "Confirm New Password",
		"birthday"         => "Birthday",

		"name_first"       => "Name",
		"name_last"        => "Last Name",
		"name_father"      => "Father Name",
		"code_melli"       => "National Id",
		"code_id"          => "ID",
		"gender"           => "Gender",
		"birth_date"       => "Birth Date",
		"birth_city"       => "Birth City",
		"marriage_date"    => "Marriage Date",
		"marital"          => "Marital",
		"occupation"       => "Occupation",
		"education"        => "Education",
		"edu_level"        => "Education Level",
		"edu_field"        => "Education Field",
		'edu_city'         => 'Education City',
		"mobile"           => 'Mobile Number',
		"telephone"        => 'Telephone',
		"tel_emergency"    => 'Emergency Phone Number',
		"home_city"        => "Home City",
		"city_id"          => 'City',
		"home_address"     => "Home Address",
		"address"          => "Postal Address",
		"home_tel"         => "Home Telephone",
		"home_postal_code" => "Home Postal Code",
		"postal_code"      => "Postal Code",
		"icon"             => "Icon",
		"donation_date"    => "Donation Date",

		"work_city"        => "Work City",
		"work_address"     => "Work Address",
		"work_tel"         => "Work Telephone",
		"work_postal_code" => "Work Postal Code",

		"job"             => "Job",
		"familization"    => "Familization",
		"motivation"      => "Motivation",
		"alloc_time"      => "Allocation Time",
		'title'           => 'Title',
		'title_two'       => 'Second Title',
		'plural_title'    => 'Plural Title',
		'singular_title'  => 'Singular Title',
		'header_title'    => 'Header Title',
		'category_title'  => 'Category Title',
		'slug'            => 'Slug',
		'cities'          => 'Cities',
		'create'          => 'Create',
		'publish'         => 'Publish',
		'publish_date'    => 'Publish Date',
		'publish_hour'    => "Publish Hour",
		'publish_minute'  => "Publish Minute",
		'abstract'        => 'Abstract',
		'text'            => 'Text',
		'category'        => 'Category',
		'keywords'        => 'Keywords',
		'allowed_meta'    => 'Allowed Meta',
		'featured_image'  => 'Featured Image',
		'image'           => 'Image',
		'card_no'         => 'Card Number',
		'organs'          => 'Organs',
		'newsletter'      => 'Newsletter',
		'reject_reason'   => 'Reason of Rejection',
		'option_true'     => 'Correct Option',
		'option_wrong_1'  => 'Wrong Option 1',
		'option_wrong_2'  => 'Wrong Option 2',
		'option_wrong_3'  => 'Wrong Option 3',
		'additional_info' => 'Additional Information',
		"token"           => "Token",
		'link'            => 'Link',

		'password_reset_token' => 'Password Reset Token',


		'content'        => 'Contetn',
		'capital_id'     => 'Seat of Province',
		'province_id'    => 'Province',
		'domain_id'      => 'Domain',
		'alias'          => 'Alias',
		'status'         => 'Status',
		'position'       => "Position",
		'current_status' => "Current Status",
		'new_status'     => "New Status",
		'level'          => 'Privilege Level',
		'domain'         => 'Domain',
		'tel'            => 'Telephone',
		'message'        => 'Message',
		'items'          => 'Items',
		'keyword'        => 'Keyword',
		'code'           => "Code",

		'branch_id'             => 'Branch',
		'value'                 => 'Value',
		'global_value'          => 'Global Value',
		'data_type'             => 'Data Type',
		'available_for_domains' => 'Privatization possibility in Domains',
		'developers_only'       => 'Developers Only',
		'is_resident'           => 'Memory Resident',
		'locales'               => "Languages",
		'locale'                => "Language",
		'post_locale'           => "Post Language",
		'is_localized'          => "Languagable",
		'default_value'         => 'Default Value',
		'custom_value'          => 'Custom Value',

		'customer_type' => 'Customer Type',
		'name_firm'     => 'Firm Name',
		'national_id'   => 'National Id',
		'register_no'   => 'Register Number',
		'register_date' => 'Register Date',
		'register_firm' => 'Registrar Firm',
		'economy_code'  => 'Economy Code',
		'gazette_url'   => 'Gazette Url',

		'bank_name'   => 'Bank Name',
		'sheba'       => 'Sheba',
		'account_no'  => 'Account Number',
		'beneficiary' => 'Beneficiary',
		'branch_name' => 'Branch Name',
		'branch_code' => 'Branch Code',

		'currency_title'       => 'Currency Title',
		'currency_slug'        => 'Currency Slug',
		'currency'             => 'Currency',
		'unit_id'              => "Unit",
		'sale_expires_at'      => "Sale Expiration Time",
		'submitted_at'         => "Submission Time",
		'price'                => 'Price',
		'is_available'         => "Enough Stock",
		'original_price'       => "Original Price",
		'discount_percent'     => "Discount Percent",
		'discount_amount'      => "Discount Amount",
		'discount'             => "Discount",
		'sale_price'           => "Sale Price",
		'price_to_sell'        => 'Price to Sell',
		'price_to_buy'         => 'Price to Buy',
		'effective_date'       => 'Effective Date',
		'date'                 => 'Date',
		'time'                 => 'Time',
		'priority'             => 'Priority',
		'department'           => 'Department',
		'feedback'             => 'Feedback',
		'charge'               => 'Charge',
		'initial_charge'       => "Initial Charge",
		'min_charge'           => 'Minimum Charge',
		'max_charge'           => 'Maximum Charge',
		'inventory'            => 'Inventory',
		'inventory_low_alarm'  => 'Inventory Low Alarm',
		'inventory_low_action' => 'Inventory Low Action',
		'description'          => 'Description',
		'properties'           => "Properties",
		'published_at'         => "Published at",
		'max_purchasable'      => 'Max Purchasable',
		'product_id'           => 'Product ID',
		'product'              => "Product",
		'invoice'              => 'Invoice',
		'original_invoice'     => "Original Invoice",
		'amount_invoiced'      => "Invoiced Amount",
		'amount'               => "Amount",
		'amount_declared'      => "Declared Amount",
		'amount_confirmed'     => "Confirmed Amount",
		'amount_payable'       => "Payable Amount",
		'amount_paid'          => "Paid Amount",
		'expiry'               => 'Expiry',
		'customer_id'          => "Customer",
		'tracking_no'          => "Tracking Number",
		'g-recaptcha-response' => "Security Code",

		'subject'                         => "Subject",
		'belongs_to'                      => "Belongs to",
		'payment_method'                  => "Payment Method",
		'payment_date'                    => "Payment Date",
		'payment_time'                    => "Payment Time",
		'payment_datetime'                => "Payment Datetime",
		'receiver'                        => "Receiver",
		'sender'                          => "Sender",
		'order_id'                        => "Order",
		'order_no'                        => "Order Number",
		'cheque_no'                       => "Cheque Number",
		'number'                          => "Number",
		'random_number'                   => "Random Number",
		'cheque_date'                     => "Cheque Date",
		'customer_account_id'             => "Customer Account Id",
		'depositor'                       => "Depositor",
		'site_credit'                     => "Site Credit",
		'checked_by'                      => "Checked by",
		'color_code'                      => "Color Code",
		'starts_at'                       => "Starts at",
		'ends_at'                         => "Ends at",
		'rate_point'                      => "Rate Point",
		'allow_anonymous_comment'         => "Allow Anonymous Comment",
		'your_comment'                    => 'Your Comment',
		'disable_receiving_comments'      => "Disable Receiving Comments",
		'disable_showing_comments'        => "Disable Showing Comments",
		'title_shown_on_sending_comments' => "Title of Sending Comment Box",
		'title_shown_on_showing_comments' => "Title of Showing Comment Box",
		'show_previous_comments'          => "Show Previous Comments",
		'reply'                           => "Reply",
		'max_per_page'                    => "Max per Page",
		'default_featured_image'          => "Default Featured Image",
		'featured_image_width'            => "Featured Image Width",
		'featured_image_height'           => "Featured Image Height",
		'fresh_time_duration'             => "Fresh Time Duration",
		'drawing_winners'                 => "Drawing Winners",
		'drawing_video'                   => "Drawing Video",
		'winners_list_post'               => "Winners List Post",

		'seat'       => 'Seat',
		'short_view' => 'Short View',
	],

	"http" => [
		'Error404' => "We don't know this page.",
		'Error403' => "You shouldn't be here!",
		'Error410' => "Who are you looking for?",
		'Error503' => "We'll get back. Soon... :)",
	],

	"hint" => [
		'unique'       => 'Unique',
		'english-only' => 'Only English Characters',
		'persian-only' => 'Only Persian Characters',
		'no_underline' => "Without Underlines",
		'icon_hint'    => 'Write one of "font-awesome" icons without "fa".',
	],

];
