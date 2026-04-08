-- Product INSERT Queries for Lilly's Nook Categories (No Subcategories)
-- Generated for main categories only: Child, General, Men, Women

-- First, let's create the products table if it doesn't exist
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id INT,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- CHILD CATEGORY PRODUCTS (Category ID: 1)
-- Collection 01 - Baby and Kids Products

INSERT INTO products (name, category_id, description, price, image, stock) VALUES
('Soft Cotton Baby Onesie', 1, 'Ultra-soft 100% organic cotton onesie perfect for newborns and toddlers', 12.99, 'baby_onesie_1.jpg', 25),
('Colorful Baby Rattle Set', 1, 'Set of 3 colorful rattles designed for tiny hands to grip easily', 8.99, 'baby_rattle_set.jpg', 30),
('Plush Teddy Bear', 1, 'Cuddly teddy bear made with hypoallergenic materials for babies', 15.99, 'teddy_bear_baby.jpg', 20),
('Baby Activity Cube', 1, '6-sided activity cube with different textures and sounds for sensory development', 22.99, 'activity_cube_baby.jpg', 15),
('Soft Baby Shoes', 1, 'Non-slip soft-soled shoes perfect for early walkers', 10.99, 'baby_shoes_soft.jpg', 35),
('Musical Mobile Toy', 1, 'Gentle musical mobile with hanging toys for crib entertainment', 18.99, 'musical_mobile_baby.jpg', 18),
('Baby Board Books Set', 1, 'Set of 5 durable board books with bright pictures and simple words', 14.99, 'board_books_baby.jpg', 22),
('Teething Toys Bundle', 1, 'Safe BPA-free teething toys in various shapes and textures', 11.99, 'teething_bundle.jpg', 28),
('Toddler Building Blocks', 1, 'Large colorful blocks safe for toddlers to stack and build', 24.99, 'toddler_blocks.jpg', 20),
('Ride-On Toy Car', 1, 'Battery-powered ride-on car with safety features for young children', 45.99, 'ride_on_car_toddler.jpg', 12),
('Wooden Puzzle Set', 1, 'Large-piece wooden puzzles featuring animals and shapes', 16.99, 'toddler_puzzles.jpg', 25),
('Toddler Art Easel', 1, 'Adjustable height easel with chalkboard and whiteboard', 32.99, 'toddler_easel.jpg', 15),
('Bubble Machine Toy', 1, 'Automatic bubble maker that creates hundreds of bubbles', 13.99, 'bubble_machine.jpg', 30),
('Toddler Kitchen Set', 1, 'Play kitchen with plastic food and utensils for imaginative play', 39.99, 'toddler_kitchen.jpg', 18),
('Soft Ball Collection', 1, 'Set of 6 soft balls in different sizes and textures', 19.99, 'soft_balls_set.jpg', 22),
('Kids Balance Bike', 1, 'No-pedal balance bike to help children learn balance and coordination', 55.99, 'balance_bike_kids.jpg', 14),
('Art Supplies Kit', 1, 'Complete art kit with washable crayons, markers, and paper', 18.99, 'art_kit_kids.jpg', 28),
('Kids Camera Toy', 1, 'Functional toy camera that takes real photos', 28.99, 'kids_camera.jpg', 18),
('Building Train Set', 1, '60-piece train track with buildings and accessories', 38.99, 'train_set_kids.jpg', 12),
('Kids Science Kit', 1, 'Beginner science experiments for curious young minds', 29.99, 'science_kit_kids.jpg', 22);

-- GENERAL CATEGORY PRODUCTS (Category ID: 2)
-- Collection 02 - General Household Items

INSERT INTO products (name, category_id, description, price, image, stock) VALUES
('Universal Storage Solution', 2, 'Versatile storage organizer suitable for any room in the house', 34.99, 'universal_storage.jpg', 25),
('Multi-Purpose Cleaning Kit', 2, 'Complete cleaning solution with eco-friendly supplies', 28.99, 'cleaning_kit.jpg', 30),
('Decorative Home Accessories Set', 2, 'Modern home decor items including vases, candles, and picture frames', 45.99, 'home_decor_set.jpg', 18),
('Organizational Bins Collection', 2, 'Set of 6 fabric bins in various sizes for organization', 39.99, 'storage_bins.jpg', 22),
('Universal Kitchen Gadgets', 2, 'Essential kitchen tools that every household needs', 32.99, 'kitchen_gadgets.jpg', 28),
('All-Purpose Home Maintenance Kit', 2, 'Basic tools and supplies for home repairs and maintenance', 54.99, 'home_maintenance.jpg', 15),
('Seasonal Decoration Bundle', 2, 'Decorative items suitable for all seasons and holidays', 41.99, 'seasonal_decor.jpg', 20),
('Universal Bath Set', 2, 'Complete bathroom accessory set with modern design', 36.99, 'bath_set.jpg', 24),
('Home Office Essentials', 2, 'Basic office supplies and organization tools', 29.99, 'office_essentials.jpg', 26),
('Universal Pet Supplies', 2, 'Essential items for common household pets', 48.99, 'pet_supplies.jpg', 19);

-- MEN CATEGORY PRODUCTS (Category ID: 3)
-- Collection 03 - Men's Fashion and Accessories

INSERT INTO products (name, category_id, description, price, image, stock) VALUES
('Classic Leather Wallet', 3, 'Genuine leather bifold wallet with multiple card slots', 34.99, 'leather_wallet.jpg', 30),
('Men\'s Sunglasses Collection', 3, 'UV protection sunglasses with modern frame designs', 24.99, 'mens_sunglasses.jpg', 35),
('Premium Watch Set', 3, 'Analog and digital watch set with interchangeable bands', 89.99, 'watch_set.jpg', 20),
('Men\'s Belt Collection', 3, 'Set of 3 genuine leather belts in different colors', 54.99, 'belt_collection.jpg', 25),
('Phone Accessory Bundle', 3, 'Complete phone accessory kit including case, charger, and stand', 29.99, 'phone_bundle.jpg', 40),
('Men\'s Grooming Kit', 3, 'Complete grooming set with premium skincare products', 44.99, 'grooming_kit.jpg', 28),
('Travel Accessory Set', 3, 'Essential travel accessories including passport holder and luggage tags', 38.99, 'travel_set.jpg', 22),
('Sports Watch Pro', 3, 'Multi-sport smartwatch with heart rate monitor and GPS', 129.99, 'sports_watch.jpg', 15),
('Classic Denim Jeans', 3, 'Straight-fit denim jeans in classic blue wash', 49.99, 'denim_jeans.jpg', 40),
('Casual Chinos', 3, 'Comfortable cotton chinos perfect for casual and business casual', 54.99, 'casual_chinos.jpg', 35),
('Athletic Joggers', 3, 'Comfortable joggers with moisture-wicking fabric', 39.99, 'athletic_joggers.jpg', 45),
('Dress Pants Collection', 3, 'Professional dress pants in navy, charcoal, and black', 69.99, 'dress_pants.jpg', 30),
('Cargo Shorts', 3, 'Utility cargo shorts with multiple pockets', 44.99, 'cargo_shorts.jpg', 38),
('Slim Fit Trousers', 3, 'Modern slim-fit trousers for office wear', 59.99, 'slim_trousers.jpg', 32),
('Work Pants Set', 3, 'Durable work pants with reinforced knees', 52.99, 'work_pants.jpg', 28),
('Classic Leather Sneakers', 3, 'Comfortable leather sneakers suitable for casual wear', 79.99, 'leather_sneakers.jpg', 35),
('Running Shoes Pro', 3, 'High-performance running shoes with advanced cushioning', 119.99, 'running_shoes.jpg', 30),
('Dress Shoes Collection', 3, 'Oxford and derby shoes in black and brown leather', 139.99, 'dress_shoes.jpg', 25),
('Hiking Boots', 3, 'Waterproof hiking boots with excellent traction', 149.99, 'hiking_boots.jpg', 20),
('Sandals and Flip-Flops', 3, 'Comfortable summer footwear collection', 34.99, 'summer_sandals.jpg', 45),
('Work Safety Shoes', 3, 'Steel-toe work shoes with slip-resistant soles', 89.99, 'work_shoes.jpg', 28),
('Basketball Shoes', 3, 'High-top basketball shoes with ankle support', 109.99, 'basketball_shoes.jpg', 22),
('Casual Loafers', 3, 'Comfortable slip-on loafers for everyday wear', 69.99, 'casual_loafers.jpg', 33),
('Premium Cotton T-Shirt', 3, '100% premium cotton t-shirt in various colors', 24.99, 'cotton_tshirt.jpg', 50),
('Graphic Tee Collection', 3, 'Set of 5 graphic t-shirts with modern designs', 44.99, 'graphic_tees.jpg', 40),
('Performance Sports Tee', 3, 'Moisture-wicking athletic t-shirt for workouts', 29.99, 'sports_tee.jpg', 45),
('Henley Shirts Set', 3, '3-pack of comfortable henley shirts', 54.99, 'henley_set.jpg', 35),
('Polo Shirt Collection', 3, 'Classic polo shirts in solid and striped patterns', 39.99, 'polo_shirts.jpg', 42),
('Long Sleeve Tees', 3, 'Comfortable long sleeve t-shirts for layering', 32.99, 'long_sleeve_tees.jpg', 38),
('V-Neck T-Shirt Pack', 3, '5-pack of v-neck t-shirts in basic colors', 49.99, 'vneck_pack.jpg', 36),
('Pocket T-Shirts', 3, 'Classic t-shirts with chest pocket detail', 27.99, 'pocket_tees.jpg', 44);

-- WOMEN CATEGORY PRODUCTS (Category ID: 4)
-- Collection 04 - Women's Fashion and Accessories

INSERT INTO products (name, category_id, description, price, image, stock) VALUES
('Summer Floral Dress', 4, 'Light and airy floral print dress perfect for summer', 49.99, 'floral_dress.jpg', 30),
('Business Casual Dress', 4, 'Professional sheath dress suitable for office wear', 69.99, 'business_dress.jpg', 25),
('Cocktail Evening Dress', 4, 'Elegant cocktail dress for special occasions', 89.99, 'cocktail_dress.jpg', 20),
('Casual Sundress Collection', 4, 'Set of 3 comfortable sundresses for everyday wear', 79.99, 'sundress_set.jpg', 35),
('Maxi Dress Set', 4, 'Floor-length maxi dresses in various patterns', 64.99, 'maxi_dresses.jpg', 28),
('Little Black Dress', 4, 'Classic little black dress with timeless style', 54.99, 'little_black_dress.jpg', 32),
('Wrap Dress Collection', 4, 'Flattering wrap dresses in solid colors', 59.99, 'wrap_dresses.jpg', 26),
('Bohemian Style Dress', 4, 'Boho-chic dress with intricate details', 74.99, 'boho_dress.jpg', 22),
('Leather Tote Bag', 4, 'Spacious genuine leather tote bag for daily use', 89.99, 'leather_tote.jpg', 25),
('Crossbody Bag Collection', 4, 'Set of 3 stylish crossbody bags in different sizes', 69.99, 'crossbody_set.jpg', 30),
('Evening Clutch', 4, 'Elegant clutch bag perfect for formal events', 44.99, 'evening_clutch.jpg', 35),
('Backpack Purse', 4, 'Fashionable backpack with purse organization', 54.99, 'backpack_purse.jpg', 28),
('Designer Handbag', 4, 'Premium designer-inspired handbag with quality materials', 129.99, 'designer_handbag.jpg', 15),
('Travel Handbag Set', 4, 'Coordinated set of bags for travel organization', 79.99, 'travel_bag_set.jpg', 20),
('Canvas Tote Collection', 4, 'Set of 4 colorful canvas totes for casual use', 39.99, 'canvas_totes.jpg', 40),
('Wallet and Purse Set', 4, 'Matching wallet and purse set in leather', 59.99, 'wallet_purse_set.jpg', 32),
('Pearl Earring Set', 4, 'Classic pearl earrings in various styles', 34.99, 'pearl_earrings.jpg', 40),
('Sterling Silver Necklace', 4, 'Elegant sterling silver necklace with pendant', 54.99, 'silver_necklace.jpg', 30),
('Fashion Bracelet Collection', 4, 'Set of 5 trendy bracelets in mixed materials', 44.99, 'bracelet_collection.jpg', 35),
('Diamond Stud Earrings', 4, 'Simple yet elegant diamond stud earrings', 149.99, 'diamond_studs.jpg', 20),
('Statement Necklace', 4, 'Bold statement necklace for special occasions', 69.99, 'statement_necklace.jpg', 25),
('Watch and Jewelry Set', 4, 'Coordinated watch and jewelry set', 89.99, 'watch_jewelry_set.jpg', 22),
('Anklet Collection', 4, 'Set of 3 delicate anklets for casual wear', 24.99, 'anklet_set.jpg', 45),
('Ring Collection Set', 4, 'Fashion ring set with various styles and sizes', 39.99, 'ring_collection.jpg', 38),
('Women\'s Dress Pants', 4, 'Professional dress pants with modern fit', 59.99, 'dress_pants_women.jpg', 35),
('Yoga Pants Collection', 4, 'Comfortable yoga pants with high waist support', 39.99, 'yoga_pants.jpg', 45),
('Casual Jeans Set', 4, 'Set of 3 pairs of jeans in different styles', 79.99, 'jeans_set.jpg', 30),
('Leggings Collection', 4, '6-pack of comfortable leggings in various colors', 54.99, 'leggings_collection.jpg', 40),
('Wide Leg Pants', 4, 'Trendy wide-leg pants for casual wear', 49.99, 'wide_leg_pants.jpg', 32),
('Culottes Set', 4, 'Fashionable culottes in seasonal colors', 44.99, 'culottes_set.jpg', 28),
('Travel Pants', 4, 'Comfortable travel pants with security features', 64.99, 'travel_pants_women.jpg', 25),
('Palazzo Pants', 4, 'Flowy palazzo pants for elegant comfort', 54.99, 'palazzo_pants.jpg', 30);

-- Summary of products created:
-- Child Category: 20 products
-- General Category: 10 products 
-- Men Category: 30 products
-- Women Category: 30 products
-- Total: 90 products

-- All products reference only main categories (no subcategories)
-- Category IDs: 1=Child, 2=General, 3=Men, 4=Women
