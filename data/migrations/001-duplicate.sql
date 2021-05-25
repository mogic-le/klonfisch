-- Use until v1.1.1

ALTER TABLE commits
CHANGE c_branch c_highest_branch varchar(128) NULL;

DELETE t1
FROM commits t1
JOIN (
SELECT c_hash, c_repository_name, Min(c_date) AS minDate, COUNT(*)
FROM commits
WHERE c_hash NOT IN (
SELECT c.c_hash FROM commits c
WHERE c.c_highest_branch = 'develop'
OR c.c_highest_branch = 'showroom'
OR c.c_highest_branch = 'master')
GROUP BY c_hash, c_repository_name
HAVING count(*) > 1 ) t2
ON t1.c_hash = t2.c_hash
AND t1.c_repository_name = t2.c_repository_name
AND t1.c_date = t2.minDate;

DELETE t1
FROM commits t1
JOIN (
SELECT c_hash, c_repository_name, COUNT(*)
FROM commits
GROUP BY c_hash, c_repository_name
HAVING count(*) > 1 ) t2
ON t1.c_hash = t2.c_hash
AND t1.c_repository_name = t2.c_repository_name
AND t1.c_highest_branch != 'develop'
AND t1.c_highest_branch != 'showroom'
AND t1.c_highest_branch != 'staging'
AND t1.c_highest_branch != 'master';

DELETE t1
FROM commits t1
JOIN (
SELECT c_hash, c_repository_name, COUNT(*)
FROM commits
GROUP BY c_hash, c_repository_name
HAVING count(*) > 1 ) t2
ON t1.c_hash = t2.c_hash
AND t1.c_repository_name = t2.c_repository_name
AND t1.c_highest_branch != 'master';

DELETE t1 FROM commits t1
JOIN (
SELECT c_hash, c_repository_name, COUNT(*)
FROM commits
GROUP BY c_hash, c_repository_name
HAVING count(*) > 1 ) t2
ON t1.c_hash = t2.c_hash
AND t1.c_repository_name = t2.c_repository_name
AND t1.c_highest_branch != 'staging';

DELETE t1 FROM commits t1
JOIN (
SELECT c_hash, c_repository_name, COUNT(*)
FROM commits
GROUP BY c_hash, c_repository_name
HAVING count(*) > 1 ) t2
ON t1.c_hash = t2.c_hash
AND t1.c_repository_name = t2.c_repository_name
AND t1.c_highest_branch != 'showroom';

DELETE t1 FROM commits t1
JOIN (
SELECT c_hash, c_repository_name, COUNT(*)
FROM commits
GROUP BY c_hash, c_repository_name
HAVING count(*) > 1 ) t2
ON t1.c_hash = t2.c_hash
AND t1.c_repository_name = t2.c_repository_name
AND t1.c_highest_branch != 'develop';

DELETE keywords_commits, keywords FROM keywords_commits
INNER JOIN keywords
ON keywords_commits.k_id = keywords.k_id
WHERE c_id NOT IN ( SELECT c_id FROM commits)
