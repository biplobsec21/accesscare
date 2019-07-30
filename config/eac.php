<?php

return [
	'date_format' => 'j M, Y',

	'user' => [
		'availableTitle' => [
			'mr' => 'Mr.',
			'ms' => 'Ms.',
			'mrs' => 'Mrs.',
			'dr' => 'Dr.',
			'prof' => 'Prof.',
		],
		'availableStatus' => [
			'Approved',
			'Pending',
			'Registering',
			'Suspended',
		],
	],

	'drug' => [
		'supplyLengths' => [
			"7",
			"15",
			"30",
			"45",
			"60",
			"90",
			"120",
			"150",
			"180",
		],
		'maxIntervalLength' => 20,
	],

	'password_length' => 8,

	/**
	 * Storage settings
	 */
	'storage' => [
		'file' => [
		    'maxSize' => '15 mb',
            'type' => 'JPG or PDF',
			'drug' => [
				'doc' => '/drug/documents',
				'resource' => '/drug/resources',
			],
			'rid' => [
				'supporting' => '/rid/support',
				'template' => '/rid/template',
				'doc' => '/rid/upload',
				'redacted' => '/rid/redacted',
			],
			'user' => [
				'cv' => '/user/cv',
				'license' => '/user/license'
			],
		],
		'name' => [
			'drug' => [
				'doc' => 'drug_document_',
				'resource' => 'drug_resource_',
			],
			'rid' => [
				'supporting' => 'rid_support_',
				'template' => 'rid_form_',
				'doc' => 'rid_document_',
				'redacted' => 'rid_redacted_',
			],
			'user' => [
				'cv' => 'user_cv_',
				'license' => 'user_license_'
			],
		],
	],

	/**
	 * Old Storage settings
	 */
	'old_storage' => [
		'upload' => [
			'drug' => [
				'document' => '/public_html/uploads/drug_doc',
				'document_upload' => '/public_html/uploads/drug_doc_upload',
				'resource' => '/public_html/uploads/drug_res',
			],
			'rid' => [
				'supporting' => '/public_html/uploads/rid_pdf_file',
			],
		],
	],

	'datamigration_password' => 'eac_migration_123',
];
