/*
----------------------------------------------------
 tb_students
----------------------------------------------------
*/
CREATE TABLE tb_students(
	id	int NOT NULL AUTO_INCREMENT,
	nis	varchar(50)	Not Null unique,
	name	varchar(100)	Not Null,
	birthplace_id	int	Not Null,
	birth_date	date		Not Null,
	religion_id	int	Not Null,
	gender ENUM('M', 'F') 	Not Null ,
	address	text Not Null,
	student_guardian_id	int	Not Null,
	is_active ENUM('Y','N') NULL DEFAULT 'N',
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,		
	create_by	int	Not Null	,
	update_at	 datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,		
	update_by	int,		
	PRIMARY KEY (id)
);

/*
----------------------------------------------------
 tb_religions
----------------------------------------------------
*/
CREATE TABLE tb_religions(
	id	int NOT NULL AUTO_INCREMENT,
	name	varchar(100) Not Null UNIQUE,
	is_active ENUM('Y','N') NULL DEFAULT 'N',
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,		
	create_by	int	Not Null	,
	update_at	 datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,		
	update_by	int,		
	PRIMARY KEY (id)
);

/*
----------------------------------------------------
 tb_cities
----------------------------------------------------
*/
CREATE TABLE tb_cities(
	id	Int	Not Null AUTO_INCREMENT,
	code	Varchar	(6) UNIQUE,	
	name	Varchar	(20)	Not Null,
	is_active ENUM('Y','N') NULL DEFAULT 'N',
	province_id	int	(11)	Not Null,
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,	
	create_by	int	Not Null,
	update_at	datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,	
	update_by	int,		
	PRIMARY KEY (id)
);

/*
----------------------------------------------------
 tb_student_guardians
----------------------------------------------------
*/
CREATE TABLE tb_student_guardians(
	id	int(11)	Not Null AUTO_INCREMENT,
	code varchar(50) UNIQUE,
	father_name	varchar(100)	Not Null,
	father_occupation_id	int(11)	,
	father_religion_id	int(11),	
	father_address	text	,	
	father_phone_number	varchar(20)	,
	mother_name	varchar(100)	Not Null,
	mother_occupation_id	int(11)	,
	mother_religion_id	int(11)	,
	mother_address	text,		
	mother_phone_number	varchar(20)	,
	student_guardian_name	varchar(100)	Not Null,
	student_guardian_occupation_id	int(11)	,
	student_guardian_religion_id	int(11)	,
	student_guardian_address	text,		
	student_guardian_phone_number	varchar(20)	,
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int	Not Null	,
	update_at	datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,		
	update_by	int,		
	PRIMARY KEY (id)
);		


/*
----------------------------------------------------
 tb_teachers
----------------------------------------------------
*/
CREATE TABLE tb_teachers(	
	id	int	(11)	Not Null	AUTO_INCREMENT,
	nip	varchar	(50)	Not Null	 UNIQUE,
	name	varchar	(100)	Not Null,	
	birthplace_id	int	(11)	Not Null	,	
	birth_date	date	Not Null	,		
	religion_id	int	(11)	Not Null	,	
	gender	char	(1) Not Null		,	
	address	text	Not Null	,		
	phone_number	varchar	(20)	,	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,		
	create_by	int	Not Null	,	
	update_at	datetime NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,		
	update_by	int		,		
	PRIMARY KEY (id)
);		

/*
----------------------------------------------------
 tb_administrators
----------------------------------------------------
*/	
CREATE TABLE tb_administrators(	
	id	int	(11)	Not Null	AUTO_INCREMENT,
	name	varchar	(100)	Not Null	,
	birthplace_id	int	(11)	Not Null	,
	birth_date	date	Not Null	,	
	religion_id	int	(11)	Not Null	,
	gender	char	(1)		Not Null,
	address	text			Not Null,
	phone_number	varchar	(20),		
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id)
);		
	
/*
----------------------------------------------------
 tb_occupations
----------------------------------------------------
*/	
CREATE TABLE tb_occupations(	
	id	int	(11)	Not Null	AUTO_INCREMENT,
	name	Varchar	(20)	Not Null			UNIQUE,
	is_active ENUM('Y','N') NULL DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id)
);

/*
----------------------------------------------------
 tb_subjects
----------------------------------------------------
*/	
CREATE TABLE tb_subjects(	
	id	int	(11)	Not Null	AUTO_INCREMENT,
	name	Varchar	(20)	Not Null			UNIQUE,
	is_active ENUM('Y','N') NULL DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id)
);

/*
----------------------------------------------------
 tb_classrooms
----------------------------------------------------
*/	
CREATE TABLE tb_classrooms(	
	id	int	(11)	Not Null	AUTO_INCREMENT,
	classroom		Varchar	(5)	Not Null UNIQUE,
	grade	varchar	(20)	Not Null,
	is_active ENUM('Y','N') NULL DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id)
);	

/*
----------------------------------------------------
 tb_school_years
----------------------------------------------------
*/	
CREATE TABLE tb_school_years(	
	id	int	(11)	Not Null	AUTO_INCREMENT,	
	school_year	tinyint	(5)	Not Null,				
	is_active ENUM('Y','N') NULL DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id),
	UNIQUE KEY `unique_school_year` (`school_year`)	
);

/*
----------------------------------------------------
 tb_classroom_details
----------------------------------------------------
*/	
CREATE TABLE tb_classroom_details(	
	id	int	(11)	Not Null	AUTO_INCREMENT,			
	classroom_id	int	Not Null,
	school_year_id	int Not Null,
	homeroom_teacher_id	int,		
	head_class_id	int,		
	is_active ENUM('Y','N') NULL DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id),
	UNIQUE KEY `unique_school_year` (`classroom_id`, `school_year_id`)	
);


/*
----------------------------------------------------
 tb_transcripts
----------------------------------------------------
*/	
CREATE TABLE tb_transcripts(	
	id	int	(11)	Not Null	AUTO_INCREMENT,		
	classroom_id	int	Not Null,
	school_year_id	int Not Null,
	semester	tinyint	(2)	Not Null,				
	student_id	int	(11)	Not Null,	
	total_value	decimal	(6,2)	Not Null,				
	average_value	decimal	(6,2)	Not Null,		
	is_active ENUM('Y','N') DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id),
	UNIQUE KEY `unique_transcripts_school_year` (`classroom_id`, `school_year_id`, `semester`, `student_id`)	
);	


/*
----------------------------------------------------
 tb_transcript_details
----------------------------------------------------
*/	
CREATE TABLE tb_transcript_details(	
	id	int	(11)	Not Null	AUTO_INCREMENT,				
	transcript_id	int(11)	Not Null,
	subject_id	int(11)	Not Null,	
	teacher_id	int	(11)	Not Null,	
	subject_teacher_id	int	(11)	Not Null,		
	score	decimal(6,2)	Not Null,		
	is_active ENUM('Y','N') DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id),
	UNIQUE KEY `unique_transcript_details_subject` (`transcript_id`, `subject_id`)	
);	

/*
----------------------------------------------------
 tb_student_classrooms
----------------------------------------------------
*/	
CREATE TABLE tb_student_classrooms(	
	id	int	(11)	Not Null	AUTO_INCREMENT,		
	student_id	int	(11)	Not Null,
	classroom_id	int	(11)	Not Null,	
	school_year_id	int	(11),		
	is_active ENUM('Y','N') DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id),
	UNIQUE KEY `unique_transcripts_school_year` (`classroom_id`, `school_year_id`,  `student_id`)	
);	


/*
----------------------------------------------------
 tb_subject_teachers
----------------------------------------------------
*/	
CREATE TABLE tb_subject_teachers(	
	id	int	(11)	Not Null	AUTO_INCREMENT,		
	subject_id	int	(11)	Not Null,
	teacher_id	int	(11)	Not Null,		
	is_active ENUM('Y','N') DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id),
	UNIQUE KEY `unique_transcripts_school_year` (`subject_id`, `teacher_id`)	
);	

/*
----------------------------------------------------
 tb_subject_teacher_classrooms
----------------------------------------------------
*/	
CREATE TABLE tb_subject_teacher_classrooms(	
	id	int	(11)	Not Null	AUTO_INCREMENT,	
	subject_teacher_id	int	(11)	Not Null,	
	classroom_id	int	(11)	Not Null,		
	school_year_id	int	(11),	
	semester	tinyint	(2)	Not Null,		
	is_active ENUM('Y','N') DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id),
	UNIQUE KEY `unique_subject_teacher_classroom` (`subject_teacher_id`, `classroom_id`, `school_year_id`, `semester`)	
);	
	
/*
----------------------------------------------------
 tb_subject_teacher_classrooms
----------------------------------------------------
*/	
CREATE TABLE tb_subject_teacher_classrooms(	
	id	int	(11)	Not Null	AUTO_INCREMENT,	
	name	varchar	50	Not Null,		
	is_active ENUM('Y','N') DEFAULT 'N',	
	create_at	datetime Not Null DEFAULT CURRENT_TIMESTAMP,			
	create_by	int		Not Null	,	
	update_at	datetime  DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,				
	update_by	int		,		
	PRIMARY KEY (id),
	UNIQUE KEY `unique_subject_teacher_classroom` (`subject_teacher_id`, `classroom_id`, `school_year_id`, `semester`)	
);	
	