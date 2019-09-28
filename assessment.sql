/*
    1. Please provide the SQL query to find the Total number of purchases, the Total amount spent
    and the Average spent by each customer, regardless of whether purchases were made.
*/
SELECT (SELECT COUNT(*)
            FROM customer_products) as totalsales,
        (SELECT AVG(p.cost)
            FROM customer_products cp
            LEFT JOIN customers c on c.customer_id = cp.customer_id
            LEFT JOIN products p on p.product_id = cp.product_id ) as averagecosts,
        (SELECT SUM(cost)
            FROM customer_products cp
            LEFT JOIN products p on p.product_id = cp.product_id) as totalcost
FROM customer_products
LIMIT 1;

/*
    2. Please provide the SQL query to find Total number of purchase made per day, the Total amount
    spent per day, and the maximum and minimum of purchases per day
*/

SELECT cp.date,SUM(cost),count(customer_id), MAX(cost), MIN(cost)
FROM customer_products cp
LEFT JOIN products p on p.product_id = cp.product_id
GROUP BY cp.date;


/*
    3. Please provide the SQL query to find the total sales for each product_category and the number
    of items sold in that category. 
*/

SELECT product_id, count(product_id)
FROM `customer_products`
group by product_id;

