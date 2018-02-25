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
    ON m.task_id = tt.task_id AND m.latest = tt.created_at) INNER JOIN users ON users.id = tt.user_id INNER JOIN task ON task.id = tt.task_id
WHERE users.name = '15B1SEAS0991';