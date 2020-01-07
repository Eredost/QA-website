# Data dictionary

## Users (`user`)

|Field|Type|Specificities|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the user|
|username|VARCHAR(180)|NOT NULL, UNIQUE|The username associated to the user|
|roles|JSON|NOT NULL|All roles assigned to the user|
|password|VARCHAR(255)|NOT NULL|The password hash used to login to the account|
|firstname|VARCHAR(20)|NULL|The firstname of the user|
|lastname|VARCHAR(20)|NULL|The lastname of the user|
|github|VARCHAR(255)|NULL|The github link of the user|
|is_enable|TINYINT(1)|NOT NULL, DEFAULT 1|Set if access to the user account is restricted|
|created_at|DATETIME|NOT NULL|The creation date of the user account|
|updated_at|DATETIME|NULL|The last update of the user profile|

## Roles (`role`)

|Field|Type|Specificities|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the role|
|name|VARCHAR(20)|NOT NULL|The name of the role|
|created_at|DATETIME|NOT NULL|The creation date of the role|
|updated_at|DATETIME|NULL|The last update of the role|

## Answers (`answer`)

|Field|Type|Specificities|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the answer|
|user_id|INT(11)|FOREIGN KEY, NOT NULL, UNSIGNED|The identifier of the user associated to the answer|
|question_id|INT(11)|FOREIGN KEY, NOT NULL, UNSIGNED|The identifier of the question associated to the answer|
|content|LONGTEXT|NOT NULL|The message body|
|is_validated|TINYINT(1)|NOT NULL|Say if the answer solved the problem of the author of the question|
|is_enable|TINYINT(1)|NOT NULL, DEFAULT 1|Set if access to the answer is restricted|
|created_at|DATETIME|NOT NULL|The creation date of the answer|
|updated_at|DATETIME|NULL|The last update of the answer|

## Questions (`question`)

|Field|Type|Specificities|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the question|
|title|VARCHAR(255)|NOT NULL|The question title|
|content|LONGTEXT|NOT NULL|The question body|
|votes|INT(11)|NOT NULL, DEFAULT 0|The number of votes provided by the community|
|is_enable|TINYINT(1)|NOT NULL, DEFAULT 1|Set if access to the question is restricted|
|created_at|DATETIME|NOT NULL|The creation date of the question|
|updated_at|DATETIME|NULL|The last update of the question|

## Tags (`tag`)

|Field|Type|Specificities|Description|
|-|-|-|-|
|id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|The identifier of the tag|
|name|VARCHAR(20)|NOT NULL|The name of the tag|
|created_at|DATETIME|NOT NULL|The creation date of the tag|
|updated_at|DATETIME|NULL|The last update of the tag|

## Question -> Tags (`question_tag`)

|Field|Type|Specificities|Description|
|-|-|-|-|
|question_id|INT(11)|PRIMARY KEY, FOREIGN KEY, NOT NULL, UNSIGNED|The question id associated to the tag|
|tag_id|INT(11)|PRIMARY KEY, FOREIGN KEY, NOT NULL, UNSIGNED|The tag id associated to the question|
