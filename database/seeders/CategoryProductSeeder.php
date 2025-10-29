<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 categories
        $categories = [
            [
                'name' => 'Fruits & Vegetables',
                'image' => 'category-thumb-1.jpg',
            ],
            [
                'name' => 'Dairy & Eggs',
                'image' => 'category-thumb-2.jpg',
            ],
            [
                'name' => 'Meat & Seafood',
                'image' => 'category-thumb-3.jpg',
            ],
            [
                'name' => 'Beverages',
                'image' => 'category-thumb-4.jpg',
            ],
            [
                'name' => 'Bakery & Snacks',
                'image' => 'category-thumb-5.jpg',
            ],
        ];

        $storage = Storage::disk('public');
        $manager = new ImageManager(new Driver());

        $createdCategories = [];
        foreach ($categories as $index => $categoryData) {
            $category = Category::create(['name' => $categoryData['name']]);
            
            // Copy and process category image
            $sourcePath = public_path('images/' . $categoryData['image']);
            if (file_exists($sourcePath)) {
                $imageContent = file_get_contents($sourcePath);
                $imagePath = "categories/{$category->id}/{$categoryData['image']}";
                $storage->put($imagePath, $imageContent);
                
                // Create thumbnail
                $img = $manager->read($sourcePath)->scale(width: Category::IMAGE_WIDTH)->toJpeg(quality: 80)->toString();
                $thumbPath = "categories/{$category->id}/thumb/" . Category::IMAGE_WIDTH . "/{$categoryData['image']}";
                $storage->put($thumbPath, $img);
                
                $category->image = "/{$categoryData['image']}";
                $category->save();
            }
            
            $createdCategories[] = $category;
        }

        // Product names for variety
        $productNames = [
            'Fresh Organic Tomatoes', 'Premium Strawberries', 'Baby Spinach', 'Red Bell Peppers',
            'Organic Carrots', 'Fresh Cucumbers', 'Sweet Corn', 'Organic Broccoli',
            'Whole Milk', 'Free Range Eggs', 'Greek Yogurt', 'Organic Cheese',
            'Premium Butter', 'Fresh Cream', 'Mozzarella Cheese', 'Farm Eggs',
            'Grass Fed Beef', 'Salmon Fillet', 'Chicken Breast', 'Fresh Shrimp',
            'Ground Turkey', 'Tuna Steak', 'Lamb Chops', 'Fresh Cod',
            'Organic Coffee', 'Green Tea', 'Fresh Orange Juice', 'Sparkling Water',
            'Energy Drink', 'Coconut Water', 'Fresh Lemonade', 'Herbal Tea',
            'Artisan Bread', 'Whole Grain Crackers', 'Organic Cookies', 'Granola Bars',
            'Fresh Bagels', 'Croissants', 'French Baguette', 'Chocolate Chip Cookies',
        ];

        // Create 30 products
        for ($i = 0; $i < 30; $i++) {
            $basePrice = rand(500, 3000) / 100; // $5.00 to $30.00
            $hasOldPrice = rand(0, 1); // 50% chance of having old price
            $oldPrice = $hasOldPrice ? $basePrice * (1 + rand(10, 40) / 100) : null; // 10-40% markup for old price
            
            $reviewCount = rand(5, 250);
            $review = rand(35, 50) / 10; // 3.5 to 5.0 rating
            
            $product = Product::create([
                'name' => $productNames[$i] ?? 'Premium Product ' . ($i + 1),
                'price' => $basePrice,
                'old_price' => $oldPrice,
                'review_count' => $reviewCount,
                'review' => $review,
                'is_popular' => rand(0, 1), // Random popular status
                'description' => 'Premium quality ' . strtolower($productNames[$i] ?? 'product ' . ($i + 1)) . ' sourced from trusted suppliers. Fresh, organic, and carefully selected for your table.',
            ]);

            // Copy and process product image
            $imageFileName = 'product-thumb-' . ($i + 1) . '.png';
            $sourcePath = public_path('images/' . $imageFileName);
            
            if (file_exists($sourcePath)) {
                // Convert PNG to JPG
                $jpgFileName = str_replace('.png', '.jpg', $imageFileName);
                
                // Read and convert to JPG for original
                $img = $manager->read($sourcePath)->toJpeg(quality: 80);
                $imagePath = "products/{$product->id}/{$jpgFileName}";
                $storage->put($imagePath, $img->toString());
                
                // Create thumbnail for product (Product::IMAGE_WIDTH = 210)
                $thumbImg = $manager->read($sourcePath)
                    ->scale(width: Product::IMAGE_WIDTH)
                    ->toJpeg(quality: 80)
                    ->toString();
                $thumbPath = "products/{$product->id}/thumb/" . Product::IMAGE_WIDTH . "/{$jpgFileName}";
                $storage->put($thumbPath, $thumbImg);
                
                $product->image = "/{$jpgFileName}";
                $product->save();
            }

            // Assign 1-3 random categories to each product
            $numberOfCategories = rand(1, 3);
            $selectedCategories = collect($createdCategories)->random($numberOfCategories);
            $product->categories()->attach($selectedCategories->pluck('id')->toArray());
        }
    }
}

