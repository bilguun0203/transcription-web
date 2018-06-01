USE `transcription-web`;
USE `transcription`;

SELECT audio.*
FROM audio
WHERE id IN (SELECT audio_id
             FROM task
             WHERE id IN (SELECT task_id
                          FROM task_transcribed
                          WHERE transcription != '<p>%өө</p>'));
-- Search audios by transcription
SELECT
  task.audio_id,
  tt.task_id,
  tt.user_id,
  tt.transcription
FROM ((SELECT
         task_id,
         MAX(created_at) AS latest
       FROM task_transcribed
       GROUP BY task_id) m INNER JOIN task_transcribed AS tt
    ON m.task_id = tt.task_id AND m.latest = tt.created_at) INNER JOIN task ON task.id = tt.task_id
WHERE tt.transcription = '<p>%өө</p>';

-- Search audios by transcribed user name
SELECT
  task.audio_id,
  tt.task_id,
  tt.user_id,
  tt.transcription
FROM ((SELECT
         task_id,
         MAX(created_at) AS latest
       FROM task_transcribed
       GROUP BY task_id) m INNER JOIN task_transcribed AS tt
    ON m.task_id = tt.task_id AND m.latest = tt.created_at) INNER JOIN users ON users.id = tt.user_id
  INNER JOIN task ON task.id = tt.task_id
WHERE users.name = '15B1SEAS0991';

-- Search by required validation (if task.status < env('VALIDATION_COUNT') => search by status = 1)
SELECT
  task.audio_id,
  tt.id,
  tt.task_id,
  tt.user_id,
  tt.transcription,
  tv.id,
  task.status,
  task.type
FROM (((SELECT
          task_id,
          MAX(created_at) AS latest
        FROM task_transcribed
        GROUP BY task_id) m INNER JOIN task_transcribed AS tt
    ON m.task_id = tt.task_id AND m.latest = tt.created_at) INNER JOIN task_validated tv
    ON tv.task_transcribed_id = tt.id)
  INNER JOIN task ON tv.task_id = task.id
WHERE task.status >= 0 AND task.status = 3 - 3;

-- Search by accepted/declined count
SELECT
  task.audio_id,
  task.id,
  tt.id,
  tt.task_id      AS taskid,
  tt.user_id      AS userid,
  tt.transcription,
  tv.id,
  tv.validation_status,
  task.status,
  task.type,
  SUM(CASE WHEN tv.validation_status = 'a'
    THEN 1
      ELSE 0 END) AS cnt
FROM (((SELECT
          task_id,
          MAX(created_at) AS latest
        FROM task_transcribed
        GROUP BY task_id) m INNER JOIN task_transcribed AS tt
    ON m.task_id = tt.task_id AND m.latest = tt.created_at) INNER JOIN task_validated tv
    ON tv.task_transcribed_id = tt.id)
  INNER JOIN task ON tv.task_id = task.id
WHERE task.status >= 0
GROUP BY task.audio_id
HAVING cnt > 0;

-- Search by status of transcription
SELECT
  task.audio_id,
  task.id,
  tt.id,
  tt.task_id,
  tt.user_id,
  tt.transcription,
  tv.id,
  tv.validation_status,
  task.status,
  task.type,
  SUM(CASE WHEN tv.validation_status = 'a'
    THEN 1
      ELSE 0 END) AS cnt
FROM (((SELECT
          task_id,
          MAX(created_at) AS latest
        FROM task_transcribed
        GROUP BY task_id) m INNER JOIN task_transcribed AS tt
    ON m.task_id = tt.task_id AND m.latest = tt.created_at) INNER JOIN task_validated tv
    ON tv.task_transcribed_id = tt.id)
  INNER JOIN task ON tv.task_id = task.id
WHERE task.status >= 0
GROUP BY task.id
HAVING cnt = 1;

-- -- No transcription
SELECT
  audio.id,
  audio.file
FROM audio
WHERE id NOT IN (SELECT audio_id
                 FROM task
                   INNER JOIN task_transcribed t2 ON task.id = t2.task_id);

#-----------------------------------------------------------------------------------------------
#-----------------------------------------------------------------------------------------------
#-----------------------------------------------------------------------------------------------

# Шалгах даалгавар хийсэн тоо
SELECT
  u.id,
  SUM(CASE WHEN validation_status = 'a'
    THEN 1
      ELSE 0 END) AS 'a',
  SUM(CASE WHEN validation_status = 'd'
    THEN 1
      ELSE 0 END) AS 'd'
FROM task_validated tv RIGHT JOIN users u ON tv.user_id = u.id
GROUP BY u.id ORDER BY u.id;

SELECT
  u.id,
  SUM(CASE WHEN validation_status = 'a'
    THEN 1
      ELSE 0 END) AS 'a',
  SUM(CASE WHEN validation_status = 'd'
    THEN 1
      ELSE 0 END) AS 'd'
FROM task_validated tv RIGHT JOIN users u ON tv.user_id = u.id
GROUP BY u.id ORDER BY u.id;

# Бичвэр болгох даалгавар хийсэн тоо

SELECT
  tt.user_id,
  COUNT(tt.id) AS transcription_count,
  SUM(CASE WHEN tt.vcount >= 3 AND tt.vstatus = 1 THEN 1 ELSE 0 END) AS total_a,
  SUM(CASE WHEN tt.vcount >= 3 AND tt.vstatus = 0 THEN 1 ELSE 0 END) AS total_d,
  SUM(CASE WHEN tt.vcount < 3 THEN 1 ELSE 0 END) AS total_p
FROM (SELECT
        tt.id,
        MAX(tt.user_id) AS user_id,
        SUM(CASE WHEN tv.validation_status = 'a'
          THEN 1
            ELSE 0 END) AS 'a',
        SUM(CASE WHEN tv.validation_status = 'd'
          THEN 1
            ELSE 0 END) AS 'd',
        COUNT(tv.id) AS 'vcount',
        (CASE WHEN SUM(CASE WHEN tv.validation_status = 'a'
          THEN 1
            ELSE 0 END) > SUM(CASE WHEN tv.validation_status = 'd'
          THEN 1
            ELSE 0 END) THEN 1 ELSE 0 END) AS 'vstatus'
      FROM task_validated tv RIGHT JOIN task_transcribed tt on tv.task_transcribed_id = tt.id
      GROUP BY tt.id HAVING user_id = 1) tt
GROUP BY tt.user_id;
