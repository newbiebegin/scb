/*
	Trigger update average and total score tb_transcript
	after_insert_transcript_detail_trigger
*/
DELIMITER //
DROP TRIGGER IF EXISTS after_insert_transcript_detail_trigger//
CREATE DEFINER=root@localhost TRIGGER after_insert_transcript_detail_trigger
    AFTER INSERT ON `tb_transcript_details`
    FOR EACH ROW

BEGIN
    -- Call the common procedure ran if there is an INSERT or UPDATE on `table`
    -- NEW.id is an example parameter passed to the procedure but is not required
    -- if you do not need to pass anything to your procedure.
    CALL update_transcript_total_score(NEW.transcript_id);
END//
DELIMITER ;

/*
	Trigger update average and total score tb_transcript 
	after_insert_transcript_detail_trigger
*/
DELIMITER //
DROP TRIGGER IF EXISTS after_update_transcript_detail_trigger//

CREATE DEFINER=root@localhost TRIGGER after_update_transcript_detail_trigger
    AFTER UPDATE ON `tb_transcript_details`
    FOR EACH ROW
BEGIN
    -- Call the common procedure ran if there is an INSERT or UPDATE on `table`
    CALL update_transcript_total_score(NEW.transcript_id);
END//
DELIMITER ;

/*
	Trigger update average and total score tb_transcript 
	after_insert_transcript_detail_trigger
*/
DELIMITER //
DROP TRIGGER IF EXISTS after_delete_transcript_detail_trigger//

CREATE DEFINER=root@localhost TRIGGER after_delete_transcript_detail_trigger
    AFTER DELETE ON `tb_transcript_details`
    FOR EACH ROW
BEGIN
    -- Call the common procedure ran if there is an INSERT or UPDATE on `table`
    CALL update_transcript_total_score(OLD.transcript_id);
END//
DELIMITER ;

/*
	Procedure update average and total score tb_transcript
	after_insert_transcript_detail_trigger
*/
DELIMITER //
DROP PROCEDURE IF EXISTS update_transcript_total_score//

CREATE DEFINER=root@localhost PROCEDURE update_transcript_total_score(
	IN in_transcript_id INTEGER(11))
BEGIN
	-- DECLARE errno INT;
    -- DECLARE EXIT HANDLER FOR SQLEXCEPTION
    -- BEGIN
    -- GET CURRENT DIAGNOSTICS CONDITION 1 errno = MYSQL_ERRNO;
    -- SELECT errno AS MYSQL_ERROR;
    -- ROLLBACK;
    -- END;
	
	-- START TRANSACTION;
		UPDATE tb_transcripts
		SET total_score = 
		(
			SELECT SUM(score) 
			FROM tb_transcript_details
			WHERE transcript_id = in_transcript_id
		),
		average_score = 
		(
			SELECT SUM(score) / COUNT(subject_id) 
			FROM tb_transcript_details
			WHERE transcript_id = in_transcript_id
		)
		WHERE id = in_transcript_id;
	-- COMMIT;
    -- Write your MySQL code to perform when a `table` row is inserted or updated here

END//
DELIMITER ;