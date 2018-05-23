CREATE VIEW repository_view AS
SELECT r.id, r.full_name, r.pushed_at, rcc.ahead_by commits_ahead_by, COUNT(pr.id) opened_pull_requests
FROM repository r
INNER JOIN repository_commit_compare rcc ON rcc.repository_id = r.id
LEFT JOIN pull_request pr ON pr.repository_id = r.id AND pr.state = 'open'
WHERE r.archived = FALSE
GROUP BY r.id, rcc.repository_id
