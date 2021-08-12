SELECT
	ma.Name_MA AS Name_MA,
	(SELECT count(c1.Client_id)
     FROM Clients c1
     JOIN MA ma1 ON c1.Ma_ID = ma1.Ma_ID
     WHERE ma1.Ma_ID = ma.Ma_ID
     AND
        (SELECT count(o2.Order_ID)
        FROM Clients c2
        JOIN orders o2 ON c2.Client_id = o2.Client_id
        WHERE c2.Client_id = c1.Client_id) > 0
    ) AS Buyers
FROM MA ma
