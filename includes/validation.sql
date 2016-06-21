-- These queries can be used to check if there are any
-- anomalies in the database.

-- Find the number of trials per IAT
-- Passes if all IATs have 200 trials
SELECT iat_id, Count(*), "FAILED" AS status
FROM trials
GROUP BY iat_id
HAVING Count(*) <> 200;

-- Find the number of IATs each subject has taken
-- Passes if each subject has taken two IATs
SELECT subject_id, Count(*), "FAILED" AS status
FROM iats
GROUP BY subject_id
HAVING Count(*) <> 2
UNION
SELECT subject_id, 0, "FAILED" AS status
FROM subjects
WHERE NOT EXISTS
  (SELECT * FROM iats
  WHERE iats.subject_id = subjects.subject_id);

-- Find if any subjects have taken more than one cheat
-- or non-cheat IATs
-- Passes if no subject has taken two or more cheat/non-cheats
SELECT subject_id, "FAILED" AS status
FROM iats AS iats1
WHERE EXISTS
  (SELECT * FROM iats AS iats2
  WHERE iats1.subject_id = iats2.subject_id
  AND iats1.cheat_type = iats2.cheat_type
  AND iats1.iat_id <> iats2.iat_id)
UNION
SELECT subject_id, "FAILED" As status
FROM iats
WHERE iats.cheat_type > 0
GROUP BY iats.subject_id
HAVING Count(*) > 1;
