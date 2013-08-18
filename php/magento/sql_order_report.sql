SELECT DATE_FORMAT(st.created_at ,  '%Y-%m' ) AS time,st.name,st.sku, SUM( st.total_qty_ordered ) AS total  FROM 
(select so.created_at,so.total_qty_ordered,so.total_paid,si.name,si.sku from sales_order so inner join sales_flat_order_item si on so.entity_id = si.order_id) st
where total_paid > 0 GROUP BY DATE_FORMAT(st.created_at ,'%Y-%m' ),st.name,st.sku having total > 0 order by time desc  

-- the orders that their invoiced are paid

SELECT DATE_FORMAT(st.created_at ,  '%Y-%m' ) AS time,st.name,st.sku, SUM( st.total_qty_ordered ) AS total  FROM 
(select so.created_at,so.total_qty_ordered,so.total_invoiced,si.name,si.sku from sales_order so inner join sales_flat_order_item si on so.entity_id = si.order_id where so.total_invoiced > 0) st
GROUP BY DATE_FORMAT(st.created_at ,'%Y-%m' ),st.name,st.sku having total > 0 order by time desc
