INSERT INTO shop_user (name, isAdmin, created_at) VALUES (
    ('John Doe', 1, '2023-11-02 08:00:00'),
    ('Alice Smith', 0, '2023-11-02 08:15:00'),
    ('Bob Johnson', 0, '2023-11-02 08:30:00'),
    ('Eve Wilson', 0, '2023-11-02 08:45:00'),
    ('Charlie Brown', 0, '2023-11-02 09:00:00'),
    ('Olivia Taylor', 0, '2023-11-02 09:15:00'),
    ('Sophia Lee', 0, '2023-11-02 09:30:00')
);          
 
INSERT INTO buyer (buyerID) VALUES (
    (1),
    (2),
    (3),
    (4),
    (5),
    (6),
    (7)
);
 
INSERT INTO seller (sellerID) VALUES (
    (1),
    (2),
    (3),
    (4),
    (5),
    (6),
    (7)
);
 
INSERT INTO wishlist (buyerID) VALUES (
    (1),
    (2),
    (3),
    (4),
    (5),
    (6),
    (7)
 );

INSERT INTO item (sid, wid, name, price, description, itemPicture, itemCat) VALUES (
    (1, 1, 'Product A', 19.99, 'Description for Product A', 'image1.jpg', 'Category1'),
    (2, 1, 'Product B', 29.99, 'Description for Product B', 'image2.jpg', 'Category2'),
    (3, 2, 'Product C', 14.99, 'Description for Product C', 'image3.jpg', 'Category1'),
    (4, 2, 'Product D', 24.99, 'Description for Product D', 'image4.jpg', 'Category3'),
    (5, 3, 'Product E', 9.99, 'Description for Product E', 'image5.jpg', 'Category2'),
    (6, 3, 'Product F', 34.99, 'Description for Product F', 'image6.jpg', 'Category3'),
    (7, 4, 'Product G', 12.99, 'Description for Product G', 'image7.jpg', 'Category1')
 );

INSERT INTO reviews (rating, message, subject, reviewerID, sellerID) VALUES (
    (5, 'Great product!', 'Product A', 2, 1),
    (4, 'Good value for money', 'Product B', 4, 2),
    (5, 'Love it!', 'Product C', 3, 3),
    (3, 'Not bad', 'Product D', 6, 4),
    (4, 'Impressed', 'Product E', 5, 5),
    (4, 'Nice product', 'Product F', 7, 6),
    (5, 'Highly recommended', 'Product G', 1, 7)
 );

INSERT INTO cart (bid) VALUES (
    (1),
    (2),
    (3),
    (4),
    (5),
    (6),
    (7)
 );

INSERT INTO cart_order (cid, date) VALUES (
    (1, '2023-11-02 10:00:00'),
    (2, '2023-08-02 10:15:00'),
    (3, '2023-03-02 10:30:00'),
    (4, '2023-11-05 10:45:00'),
    (5, '2023-07-04 11:00:00'),
    (6, '2023-04-02 11:15:00'),
    (7, '2023-12-02 11:30:00')
 );

 
INSERT INTO contains (itemID, cartID) VALUES (
    (1, 1),
    (2, 1),
    (3, 2),
    (4, 2),
    (5, 3),
    (6, 4),
    (7, 7)
 );
