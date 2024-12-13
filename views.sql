-- get total project specified donation and direct donation
create view donation_breakdown as
(
SELECT 'direct'                                                              AS type,
       SUM(CASE WHEN d.project_id IS NULL THEN p.donation_amount ELSE 0 END) AS donation
FROM payments p
         JOIN donations d ON p.donation_id = d.id
WHERE p.status = 1
UNION ALL
SELECT 'project'                                                                 AS type,
       SUM(CASE WHEN d.project_id IS NOT NULL THEN p.donation_amount ELSE 0 END) AS donation
FROM payments p
         JOIN donations d ON p.donation_id = d.id
WHERE p.status = 1
    );

CREATE VIEW donation_last AS
WITH RECURSIVE date_series AS
                   (SELECT CURDATE() - INTERVAL 14 DAY AS payment_date
                    UNION ALL
                    SELECT payment_date + INTERVAL 1 DAY
                    FROM date_series
                    WHERE payment_date < CURDATE())
SELECT ds.payment_date,
       COALESCE(SUM(p.donation_amount), 0) AS total_donation
FROM date_series ds
         LEFT JOIN
     collecte_don.payments p ON DATE(p.created_at) = ds.payment_date
GROUP BY ds.payment_date
ORDER BY ds.payment_date DESC;

select projects.id, count(d.id) as count
from projects
         left join donations d on projects.id = d.project_id
         left join v_valid_payments p on d.id = p.donation_id
group by projects.id;

create view project_avg_donation as
(
select projects.id, projects.title, coalesce(avg(p.donation_amount), 0)
from projects
         left join donations d on projects.id = d.project_id
         left join v_valid_payments p on d.id = p.donation_id
group by projects.id
    );

create view v_users_client as
(
select *
from users
where is_admin = 0
);

create view v_users_donation_count as
(
select u.id, u.name, count(p.id)
from v_valid_payments p
         left join donations d on p.donation_id = d.id
         right join v_users_client u on d.user_id = u.id
group by u.id
);

create view v_donator_new_and_returned as
(select 'new' as category, count(*) as donation_count
from v_users_donation_count
where v_users_donation_count.donation_count = 1
union all
select 'returned' as category, count(*) as donation_count
from v_users_donation_count
where v_users_donation_count.donation_count > 1);

select sum(donation_amount) as total from v_valid_payments;

select count(id) as count from v_users_donation_count where donation_count > 0;

select sum(donation_count) total from v_users_donation_count;

select u.id, u.name, coalesce(sum(p.donation_amount), 0) as total
from v_valid_payments p
         left join donations d on p.donation_id = d.id
         right join v_users_client u on d.user_id = u.id
group by u.id
order by total desc
limit 1;

select u.id, u.name, u.email, ud.total from users u join v_users_donation ud on u.id = ud.id;
