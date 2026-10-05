<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecipeController extends Controller
{
    private function getCuratedRecipes()
    {
        return [
            [
                'id' => '1',
                'name' => 'Signature Steamed Dumplings',
                'category' => 'Appetizers',
                'tag' => 'SIGNATURE',
                'subtitle' => 'Pangsit kukus lembut berisi daging ayam cincang, jamur shiitake, dan saus cabai spesial.',
                'image' => 'https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?auto=format&fit=crop&w=800&q=80',
                'plate_image' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?auto=format&fit=crop&w=600&q=80',
                'prep_time' => '25 Menit',
                'cook_time' => '15 Menit',
                'calories' => '320 kkal',
                'servings' => '4 Porsi',
                'difficulty' => 'Sedang',
                'rating' => 4.9,
                'reviews_count' => 128,
                'price' => 'Rp 45.000',
                'description' => 'Dumpling klasik dengan kulit kenyal transparan dan isian daging ayam beraroma minyak wijen serta jahe segar. Disajikan bersama saus cocolan cabai pedas manis dan daun bawang iris.',
                'ingredients' => [
                    ['id' => 'ing-1', 'name' => 'Kulit Pangsit / Dumpling Wrappers', 'amount' => '20 lembar', 'icon' => '🥟', 'category' => 'Bases'],
                    ['id' => 'ing-2', 'name' => 'Daging Ayam Cincang Halus', 'amount' => '250 gram', 'icon' => '🍗', 'category' => 'Protein'],
                    ['id' => 'ing-3', 'name' => 'Jamur Shiitake Cincang', 'amount' => '4 buah', 'icon' => '🍄', 'category' => 'Toppings'],
                    ['id' => 'ing-4', 'name' => 'Daun Bawang Iris Tipis', 'amount' => '2 batang', 'icon' => '🌿', 'category' => 'Toppings'],
                    ['id' => 'ing-5', 'name' => 'Minyak Wijen & Kecap Asin', 'amount' => '1.5 sdm', 'icon' => '🍶', 'category' => 'Seasoning'],
                    ['id' => 'ing-6', 'name' => 'Bawang Putih & Jahe Parut', 'amount' => '1 sdt', 'icon' => '🧄', 'category' => 'Seasoning'],
                    ['id' => 'ing-7', 'name' => 'Saus Cabai & Minyak Cabe', 'amount' => '2 sdm', 'icon' => '🌶️', 'category' => 'Dressings']
                ],
                'instructions' => [
                    ['step' => 1, 'title' => 'Menyiapkan Isian', 'desc' => 'Campurkan daging ayam cincang, jamur shiitake, daun bawang, bawang putih, jahe parut, minyak wijen, kecap asin, garam, dan lada dalam mangkuk. Aduk searah jarum jam hingga adonan kenyal.'],
                    ['step' => 2, 'title' => 'Membungkus Pangsit', 'desc' => 'Ambil selembar kulit pangsit, letakkan 1 sendok teh adonan di tengah. Basahi tepian kulit dengan sedikit air, lalu lipat dan bentuk lipatan plisket rapat di bagian atasnya.'],
                    ['step' => 3, 'title' => 'Mengukus Dumpling', 'desc' => 'Alasi kukusan dengan daun selada atau kertas baking. Kukus pangsit di atas air mendidih selama 12-15 menit hingga matang sempurna dan kulitnya berkilau.'],
                    ['step' => 4, 'title' => 'Penyajian Hangat', 'desc' => 'Sajikan segera di atas piring kayu tradisional bersama cocolan saus cabai spesial dan taburan biji wijen hitam.']
                ]
            ],
            [
                'id' => '2',
                'name' => 'Stirred Egg with Tomato',
                'category' => 'Main Dish',
                'tag' => 'POPULAR',
                'subtitle' => 'Hidangan rumahan legendaris perpaduan telur lembut dan tomat segar asam manis.',
                'image' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=800&q=80',
                'plate_image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80',
                'prep_time' => '10 Menit',
                'cook_time' => '8 Menit',
                'calories' => '240 kkal',
                'servings' => '2 Porsi',
                'difficulty' => 'Mudah',
                'rating' => 4.8,
                'reviews_count' => 95,
                'price' => 'Rp 28.000',
                'description' => 'Menu klasik yang sangat disukai semua kalangan. Telur orak-arik creamy yang dimasak lembut berpadu dengan kuah sari tomat matang yang segar, manis alami, dan gurih.',
                'ingredients' => [
                    ['id' => 'ing-1', 'name' => 'Telur Ayam Segar', 'amount' => '4 butir', 'icon' => '🥚', 'category' => 'Protein'],
                    ['id' => 'ing-2', 'name' => 'Tomat Merah Matang Potong Wedges', 'amount' => '3 buah', 'icon' => '🍅', 'category' => 'Bases'],
                    ['id' => 'ing-3', 'name' => 'Daun Bawang Iris', 'amount' => '2 batang', 'icon' => '🌿', 'category' => 'Toppings'],
                    ['id' => 'ing-4', 'name' => 'Gula Pasir & Garam', 'amount' => '1 sdt', 'icon' => '🧂', 'category' => 'Seasoning'],
                    ['id' => 'ing-5', 'name' => 'Minyak Goreng & Minyak Wijen', 'amount' => '2 sdm', 'icon' => '🍶', 'category' => 'Seasoning'],
                    ['id' => 'ing-6', 'name' => 'Kecap Asin / Soy Sauce', 'amount' => '1 sdt', 'icon' => '🥢', 'category' => 'Seasoning']
                ],
                'instructions' => [
                    ['step' => 1, 'title' => 'Kocok & Masak Telur', 'desc' => 'Kocok lepas telur dengan sedikit garam. Panaskan wajan dengan 1.5 sdm minyak, tuang telur dan orak-arik sebentar hingga setengah matang bertekstur fluffy. Angkat dan sisihkan.'],
                    ['step' => 2, 'title' => 'Tumis Tomat', 'desc' => 'Dalam wajan yang sama, tambahkan sisa minyak. Masukkan potongan tomat, tumis hingga empuk dan mengeluarkan sari jus tomat yang kental (tambahkan 2 sdm air dan gula pasir).'],
                    ['step' => 3, 'title' => 'Satukan Bahan', 'desc' => 'Masukkan kembali telur orak-arik ke dalam tumisan tomat. Aduk perlahan agar telur menyerap kuah tomat tanpa hancur.'],
                    ['step' => 4, 'title' => 'Finishing', 'desc' => 'Taburi daun bawang iris dan tetesan minyak wijen. Sajikan selagi hangat bersama sepiring nasi putih pulen.']
                ]
            ],
            [
                'id' => '3',
                'name' => 'Classic Kung Pao Chicken',
                'category' => 'Main Dish',
                'tag' => 'BESTSELLER',
                'subtitle' => 'Ayam tumis pedas gurih khas Sichuan dengan kacang tanah renyah dan cabai kering.',
                'image' => 'https://images.unsplash.com/photo-1525755662778-989d0524087e?auto=format&fit=crop&w=800&q=80',
                'plate_image' => 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=600&q=80',
                'prep_time' => '20 Menit',
                'cook_time' => '12 Menit',
                'calories' => '480 kkal',
                'servings' => '3 Porsi',
                'difficulty' => 'Sedang',
                'rating' => 4.9,
                'reviews_count' => 210,
                'price' => 'Rp 52.000',
                'description' => 'Dada ayam potong dadu yang dimarinasi empuk, ditumis dalam saus karamel pedas asam manis bersama lada Sichuan, cabai kering utuh, daun bawang, dan kacang tanah sangrai renyah.',
                'ingredients' => [
                    ['id' => 'ing-1', 'name' => 'Dada Ayam Potong Dadu', 'amount' => '350 gram', 'icon' => '🍗', 'category' => 'Protein'],
                    ['id' => 'ing-2', 'name' => 'Kacang Tanah Goreng / Sangrai', 'amount' => '50 gram', 'icon' => '🥜', 'category' => 'Toppings'],
                    ['id' => 'ing-3', 'name' => 'Cabai Kering Utuh', 'amount' => '8-10 buah', 'icon' => '🌶️', 'category' => 'Toppings'],
                    ['id' => 'ing-4', 'name' => 'Daun Bawang & Bawang Putih', 'amount' => '3 siung', 'icon' => '🧄', 'category' => 'Bases'],
                    ['id' => 'ing-5', 'name' => 'Kecap Manis, Asin & Saus Tiram', 'amount' => '2 sdm', 'icon' => '🍶', 'category' => 'Dressings'],
                    ['id' => 'ing-6', 'name' => 'Cuka Hitam / Rice Vinegar & Tepung Maizena', 'amount' => '1 sdm', 'icon' => '🌾', 'category' => 'Seasoning']
                ],
                'instructions' => [
                    ['step' => 1, 'title' => 'Marinasi Ayam', 'desc' => 'Campurkan potongan ayam dengan kecap asin, sedikit maizena, dan minyak wijen. Diamkan selama 15 menit agar bumbu meresap.'],
                    ['step' => 2, 'title' => 'Racik Saus Kung Pao', 'desc' => 'Campur kecap asin, saus tiram, cuka beras, gula pasir, kaldu, dan 1 sdt maizena dalam mangkuk kecil.'],
                    ['step' => 3, 'title' => 'Tumis Cepat (Wok Hei)', 'desc' => 'Panaskan minyak di wajan wok. Tumis cabai kering dan bawang putih hingga harum semerbak, lalu masukkan ayam dan masak hingga berubah warna kecokelatan.'],
                    ['step' => 4, 'title' => 'Karamelisasi & Penyajian', 'desc' => 'Tuang racikan saus, aduk cepat hingga mengental dan melapisi ayam. Masukkan kacang tanah sangrai dan daun bawang, aduk 30 detik lalu angkat.']
                ]
            ],
            [
                'id' => '4',
                'name' => 'Chicken + Brussels Harvest Bowl',
                'category' => 'Warm Bowls',
                'tag' => 'HEALTHY',
                'subtitle' => 'Mangkuk bernutrisi tinggi dengan ayam panggang rempah, kubis brussel karamel, dan ubi panggang.',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80',
                'plate_image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=600&q=80',
                'prep_time' => '15 Menit',
                'cook_time' => '20 Menit',
                'calories' => '485 kkal',
                'servings' => '1 Porsi Besar',
                'difficulty' => 'Mudah',
                'rating' => 4.95,
                'reviews_count' => 174,
                'price' => 'Rp 58.000',
                'description' => 'Menu favorit bergaya Sweetgreen! Perpaduan romaine segar, ubi madu panggang dadu manis, brussels sprouts panggang gurih renyah, irisan apel segar, kismis, kacang almond, dan dressing berry balsamic.',
                'ingredients' => [
                    ['id' => 'ing-1', 'name' => 'Daun Selada Romaine Segar', 'amount' => '100 gram', 'icon' => '🥬', 'category' => 'Bases'],
                    ['id' => 'ing-2', 'name' => 'Spring Mix / Baby Greens', 'amount' => '50 gram', 'icon' => '🥗', 'category' => 'Bases'],
                    ['id' => 'ing-3', 'name' => 'Ubi Panggang / Roasted Sweet Potato', 'amount' => '80 gram', 'icon' => '🍠', 'category' => 'Bases'],
                    ['id' => 'ing-4', 'name' => 'Dada Ayam Panggang Herb Rempah', 'amount' => '120 gram', 'icon' => '🍗', 'category' => 'Protein'],
                    ['id' => 'ing-5', 'name' => 'Roasted Brussels Sprouts', 'amount' => '60 gram', 'icon' => '🥦', 'category' => 'Toppings'],
                    ['id' => 'ing-6', 'name' => 'Irisan Apel Segar & Kismis', 'amount' => '40 gram', 'icon' => '🍎', 'category' => 'Toppings'],
                    ['id' => 'ing-7', 'name' => 'Kacang Almond Panggang Cincang', 'amount' => '20 gram', 'icon' => '🌰', 'category' => 'Toppings'],
                    ['id' => 'ing-8', 'name' => 'Cranberry Balsamic Vinaigrette', 'amount' => '3 sdm', 'icon' => '🥣', 'category' => 'Dressings']
                ],
                'instructions' => [
                    ['step' => 1, 'title' => 'Memanggang Sayuran', 'desc' => 'Lumuri potongan ubi dan brussels sprouts dengan minyak zaitun, garam, dan lada hitam. Panggang di oven/airfryer suhu 200°C selama 15 menit hingga karamel keemasan.'],
                    ['step' => 2, 'title' => 'Panggang Ayam', 'desc' => 'Bumbui dada ayam dengan rosemary, paprika bubuk, bawang putih, dan garam. Panggang hingga matang juicy lalu iris tebal.'],
                    ['step' => 3, 'title' => 'Menata Sayuran Segar', 'desc' => 'Susun selada romaine dan spring mix di dasar mangkuk saji.'],
                    ['step' => 4, 'title' => 'Plating & Dressing', 'desc' => 'Tata ayam panggang, ubi madu, brussels sprouts, irisan apel segar, kismis, dan taburan almond di atasnya. Siram dengan dressing cranberry balsamic hangat.']
                ]
            ],
            [
                'id' => '5',
                'name' => 'Kale Caesar Salad with Parmesan Crisps',
                'category' => 'Salads',
                'tag' => 'POPULAR',
                'subtitle' => 'Salad kale renyah dengan keju parmesan iris, tomat ceri, dan perasan jeruk limau segar.',
                'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=800&q=80',
                'plate_image' => 'https://images.unsplash.com/photo-1505253716362-afaea1d3d1af?auto=format&fit=crop&w=600&q=80',
                'prep_time' => '15 Menit',
                'cook_time' => '5 Menit',
                'calories' => '390 kkal',
                'servings' => '2 Porsi',
                'difficulty' => 'Mudah',
                'rating' => 4.7,
                'reviews_count' => 88,
                'price' => 'Rp 48.000',
                'description' => 'Salad kaya antioksidan yang memadukan daun kale muda cincang, selada romaine renyah, potongan ayam panggang gurih, keripik keju parmesan, tomat ceri manis, dan dressing Caesar creamy segar.',
                'ingredients' => [
                    ['id' => 'ing-1', 'name' => 'Daun Kale Muda Cincang', 'amount' => '120 gram', 'icon' => '🥬', 'category' => 'Bases'],
                    ['id' => 'ing-2', 'name' => 'Selada Romaine Segar', 'amount' => '80 gram', 'icon' => '🥗', 'category' => 'Bases'],
                    ['id' => 'ing-3', 'name' => 'Ayam Panggang Suwir Lembut', 'amount' => '100 gram', 'icon' => '🍗', 'category' => 'Protein'],
                    ['id' => 'ing-4', 'name' => 'Tomat Ceri Belah Dua', 'amount' => '8 butir', 'icon' => '🍅', 'category' => 'Toppings'],
                    ['id' => 'ing-5', 'name' => 'Keju Parmesan Crisps / Parut', 'amount' => '30 gram', 'icon' => '🧀', 'category' => 'Toppings'],
                    ['id' => 'ing-6', 'name' => 'Perasan Jeruk Limau / Lime Squeeze', 'amount' => '1 buah', 'icon' => '🍋', 'category' => 'Seasoning'],
                    ['id' => 'ing-7', 'name' => 'Caesar Dressing Creamy', 'amount' => '3 sdm', 'icon' => '🥣', 'category' => 'Dressings']
                ],
                'instructions' => [
                    ['step' => 1, 'title' => 'Massage Daun Kale', 'desc' => 'Beri sedikit minyak zaitun dan garam pada daun kale cincang, lalu remas-remas lembut selama 1 menit agar seratnya empuk dan tidak pahit.'],
                    ['step' => 2, 'title' => 'Campur Sayuran', 'desc' => 'Satukan kale dengan potongan selada romaine dan tomat ceri segar di dalam mangkuk besar.'],
                    ['step' => 3, 'title' => 'Tuang Dressing & Aduk', 'desc' => 'Tuangkan caesar dressing dan perasan air jeruk limau, aduk merata hingga seluruh daun terlapisi lembut.'],
                    ['step' => 4, 'title' => 'Topping & Sajikan', 'desc' => 'Beri topping potongan ayam panggang dan keripik parmesan renyah di atasnya. Siap dinikmati!']
                ]
            ],
            [
                'id' => '6',
                'name' => 'Guacamole Greens Harvest Bowl',
                'category' => 'Salads',
                'tag' => 'FRESH',
                'subtitle' => 'Alpukat mentega lembut, keripik tortilla renyah, kol ungu, dan dressing lime cilantro jalapeño.',
                'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80',
                'plate_image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80',
                'prep_time' => '15 Menit',
                'cook_time' => '10 Menit',
                'calories' => '520 kkal',
                'servings' => '1 Porsi',
                'difficulty' => 'Mudah',
                'rating' => 4.9,
                'reviews_count' => 142,
                'price' => 'Rp 55.000',
                'description' => 'Kombinasi rasa segar tropis khas Meksiko. Alpukat mentega creamy bersanding dengan ayam bakar bumbu fajita, kubis ungu serut, keripik tortilla jagung, dan saus jalapeño cilantro segar.',
                'ingredients' => [
                    ['id' => 'ing-1', 'name' => 'Alpukat Mentega Matang Potong Dadu', 'amount' => '1 buah', 'icon' => '🥑', 'category' => 'Toppings'],
                    ['id' => 'ing-2', 'name' => 'Dada Ayam Bakar Fajita', 'amount' => '100 gram', 'icon' => '🍗', 'category' => 'Protein'],
                    ['id' => 'ing-3', 'name' => 'Keripik Tortilla Jagung Remuk Kasar', 'amount' => '30 gram', 'icon' => '🌽', 'category' => 'Toppings'],
                    ['id' => 'ing-4', 'name' => 'Kubis Ungu / Shredded Cabbage', 'amount' => '50 gram', 'icon' => '🥗', 'category' => 'Bases'],
                    ['id' => 'ing-5', 'name' => 'Bawang Merah Iris Halus / Red Onions', 'amount' => '2 sdm', 'icon' => '🧅', 'category' => 'Toppings'],
                    ['id' => 'ing-6', 'name' => 'Lime Cilantro Jalapeño Vinaigrette', 'amount' => '3 sdm', 'icon' => '🌶️', 'category' => 'Dressings']
                ],
                'instructions' => [
                    ['step' => 1, 'title' => 'Siapkan Sayuran', 'desc' => 'Cuci bersih dan iris tipis selada serta kubis ungu. Masukkan ke dalam mangkuk saji.'],
                    ['step' => 2, 'title' => 'Tambahkan Topping Segar', 'desc' => 'Susun potongan alpukat mentega, irisan bawang merah, dan tomat ceri di atas alas sayuran.'],
                    ['step' => 3, 'title' => 'Letakkan Ayam & Tortilla', 'desc' => 'Letakkan potongan ayam bakar hangat di tengah, lalu taburi dengan remukan keripik tortilla gurih.'],
                    ['step' => 4, 'title' => 'Drizzle Vinaigrette', 'desc' => 'Siram dengan saus lime cilantro jalapeño dan sajikan dengan irisan jeruk nipis segar di sampingnya.']
                ]
            ],
            [
                'id' => '7',
                'name' => 'Sweet Pork Chops with Garlic Butter',
                'category' => 'Main Dish',
                'tag' => 'CHEF SPECIAL',
                'subtitle' => 'Daging empuk dengan karamelisasi saus madu bawang putih dan sayuran panggang.',
                'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80',
                'plate_image' => 'https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?auto=format&fit=crop&w=600&q=80',
                'prep_time' => '15 Menit',
                'cook_time' => '18 Menit',
                'calories' => '540 kkal',
                'servings' => '2 Porsi',
                'difficulty' => 'Sedang',
                'rating' => 4.85,
                'reviews_count' => 64,
                'price' => 'Rp 65.000',
                'description' => 'Daging berkualitas yang dipanggang pan-seared hingga bagian luarnya caramelized keemasan dengan saus madu, bawang putih cincang, mentega gurih, dan brokoli panggang.',
                'ingredients' => [
                    ['id' => 'ing-1', 'name' => 'Daging Potongan Tebal (Chops)', 'amount' => '300 gram', 'icon' => '🥩', 'category' => 'Protein'],
                    ['id' => 'ing-2', 'name' => 'Mentega / Butter Berkualitas', 'amount' => '2 sdm', 'icon' => '🧈', 'category' => 'Seasoning'],
                    ['id' => 'ing-3', 'name' => 'Madu Murni & Saus Tiram', 'amount' => '2 sdm', 'icon' => '🍯', 'category' => 'Dressings'],
                    ['id' => 'ing-4', 'name' => 'Bawang Putih Geprek Cincang', 'amount' => '4 siung', 'icon' => '🧄', 'category' => 'Seasoning'],
                    ['id' => 'ing-5', 'name' => 'Brokoli & Wortel Panggang', 'amount' => '100 gram', 'icon' => '🥦', 'category' => 'Toppings'],
                    ['id' => 'ing-6', 'name' => 'Rosemary Segar & Lada Hitam', 'amount' => '1 sdt', 'icon' => '🌿', 'category' => 'Seasoning']
                ],
                'instructions' => [
                    ['step' => 1, 'title' => 'Bumbui Daging', 'desc' => 'Keringkan permukaan daging dengan tisu dapur. Taburi garam laut dan lada hitam tumbuk kasar di kedua sisinya.'],
                    ['step' => 2, 'title' => 'Pan-Sear Daging', 'desc' => 'Panaskan cast iron skillet dengan sedikit minyak. Masak daging selama 4-5 menit di tiap sisi hingga terbentuk kerak karamel cokelat keemasan.'],
                    ['step' => 3, 'title' => 'Basting Mentega & Madu', 'desc' => 'Kecilkan api, masukkan mentega, bawang putih cincang, madu, dan rosemary. Sendokkan lelehan mentega panas berulang kali ke atas daging (basting) selama 2 menit.'],
                    ['step' => 4, 'title' => 'Resting & Sajikan', 'desc' => 'Diamkan daging selama 5 menit sebelum dipotong agar sari jus daging tetap juicy. Sajikan bersama brokoli panggang.']
                ]
            ],
            [
                'id' => '8',
                'name' => 'Buffalo Chicken Warm Bowl',
                'category' => 'Warm Bowls',
                'tag' => 'SPICY',
                'subtitle' => 'Ayam bumbu pedas manis, keju biru leleh, wortel acar renyah, dan saus rempah hangat.',
                'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=800&q=80',
                'plate_image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80',
                'prep_time' => '15 Menit',
                'cook_time' => '15 Menit',
                'calories' => '510 kkal',
                'servings' => '1 Porsi',
                'difficulty' => 'Sedang',
                'rating' => 4.8,
                'reviews_count' => 115,
                'price' => 'Rp 56.000',
                'description' => 'Mangkuk hangat yang membangkitkan selera dengan potongan ayam bakar rempah bercampur saus buffalo pedas gurih, zaatar breadcrumbs renyah, acar wortel seledri, dan daun kale hangat.',
                'ingredients' => [
                    ['id' => 'ing-1', 'name' => 'Ayam Panggang Blackened', 'amount' => '120 gram', 'icon' => '🍗', 'category' => 'Protein'],
                    ['id' => 'ing-2', 'name' => 'Saus Buffalo Hot Sauce', 'amount' => '3 sdm', 'icon' => '🌶️', 'category' => 'Dressings'],
                    ['id' => 'ing-3', 'name' => 'Acar Wortel & Seledri Renyah', 'amount' => '50 gram', 'icon' => '🥕', 'category' => 'Toppings'],
                    ['id' => 'ing-4', 'name' => 'Keju Biru / Blue Cheese Crumbles', 'amount' => '25 gram', 'icon' => '🧀', 'category' => 'Toppings'],
                    ['id' => 'ing-5', 'name' => 'Zaatar Breadcrumbs Crispy', 'amount' => '20 gram', 'icon' => '🍞', 'category' => 'Toppings'],
                    ['id' => 'ing-6', 'name' => 'Nasi Quinoa Hangat & Selada Romaine', 'amount' => '120 gram', 'icon' => '🍚', 'category' => 'Bases']
                ],
                'instructions' => [
                    ['step' => 1, 'title' => 'Siapkan Nasi Quinoa', 'desc' => 'Letakkan nasi quinoa hangat dan selada romaine cincang di dasar mangkuk.'],
                    ['step' => 2, 'title' => 'Masak Ayam Buffalo', 'desc' => 'Tumis potongan ayam panggang dengan saus buffalo pedas hingga saus melapisi ayam dengan kental mengkilap.'],
                    ['step' => 3, 'title' => 'Plating Komposisi', 'desc' => 'Tata ayam buffalo, acar wortel seledri, dan tomat di atas mangkuk.'],
                    ['step' => 4, 'title' => 'Garnish Renyah', 'desc' => 'Taburkan remahan blue cheese dan zaatar breadcrumbs yang gurih renyah sebelum disantap.']
                ]
            ]
        ];
    }

    public function index(Request $request)
    {
        $recipes = $this->getCuratedRecipes();
        $categories = ['All', 'Appetizers', 'Main Dish', 'Salads', 'Warm Bowls'];

        return view('recipes', [
            'recipes' => $recipes,
            'categories' => $categories,
            'featuredRecipe' => $recipes[0]
        ]);
    }

    public function show($id)
    {
        $recipes = collect($this->getCuratedRecipes());
        $recipe = $recipes->firstWhere('id', $id) ?? $recipes->first();

        return view('recipes', [
            'recipes' => $recipes->all(),
            'categories' => ['All', 'Appetizers', 'Main Dish', 'Salads', 'Warm Bowls'],
            'featuredRecipe' => $recipe,
            'autoOpenId' => $id
        ]);
    }

    public function apiIndex()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->getCuratedRecipes()
        ]);
    }

    public function apiShow($id)
    {
        $recipe = collect($this->getCuratedRecipes())->firstWhere('id', $id);
        if (!$recipe) {
            return response()->json(['status' => 'error', 'message' => 'Resep tidak ditemukan'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $recipe]);
    }

    /**
     * Endpoint Pencarian Resep (Mendukung API Ninjas & Local Catalog)
     * URL: /api/recipes/search?query=chicken&api_key=...
     */
    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));
        $apiKey = $request->input('api_key') ?? env('API_NINJAS_KEY');

        $results = [];

        // 1. Coba Cari ke API Ninjas jika API Key tersedia
        if (!empty($apiKey) && !empty($query)) {
            try {
                // API Ninjas Recipe endpoint: https://api.api-ninjas.com/v1/recipe?query=...
                $response = Http::withHeaders([
                    'X-Api-Key' => $apiKey,
                ])->timeout(4)->get('https://api.api-ninjas.com/v1/recipe', [
                    'query' => $query
                ]);

                if ($response->successful()) {
                    $ninjaRecipes = $response->json();
                    foreach ($ninjaRecipes as $idx => $ninja) {
                        // Format ingredients list from string (separated by | or commas)
                        $rawIngs = explode('|', $ninja['ingredients'] ?? '');
                        $formattedIngs = [];
                        foreach ($rawIngs as $iKey => $ingStr) {
                            $ingTrim = trim($ingStr);
                            if (!empty($ingTrim)) {
                                $formattedIngs[] = [
                                    'id' => 'ninja-ing-' . $iKey,
                                    'name' => $ingTrim,
                                    'amount' => 'Secukupnya',
                                    'icon' => '🥗',
                                    'category' => 'Bahan'
                                ];
                            }
                        }

                        // Format instructions into numbered steps
                        $rawSteps = explode('.', $ninja['instructions'] ?? '');
                        $formattedSteps = [];
                        $stepCounter = 1;
                        foreach ($rawSteps as $st) {
                            $stTrim = trim($st);
                            if (strlen($stTrim) > 8) {
                                $formattedSteps[] = [
                                    'step' => $stepCounter++,
                                    'title' => 'Langkah ' . ($stepCounter - 1),
                                    'desc' => $stTrim . '.'
                                ];
                            }
                        }

                        $results[] = [
                            'id' => 'ninja-' . ($idx + 100),
                            'name' => $ninja['title'] ?? 'Resep Masakan',
                            'category' => 'Chef Choice',
                            'tag' => 'API NINJAS',
                            'subtitle' => 'Resep segar dari database API Ninjas: ' . ($ninja['servings'] ?? '2-4 Porsi'),
                            'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80',
                            'plate_image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=600&q=80',
                            'prep_time' => '15 Menit',
                            'cook_time' => '25 Menit',
                            'calories' => '420 kkal',
                            'servings' => $ninja['servings'] ?? '4 Porsi',
                            'difficulty' => 'Sedang',
                            'rating' => 4.8,
                            'reviews_count' => 45,
                            'price' => 'Rp 50.000',
                            'description' => $ninja['instructions'] ?? 'Resep lezat siap saji.',
                            'ingredients' => $formattedIngs,
                            'instructions' => $formattedSteps
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Ignore and fallback to local catalog
            }
        }

        // 2. Filter dari Katalog Lokal
        $localMatches = collect($this->getCuratedRecipes())->filter(function ($item) use ($query) {
            if (empty($query)) return true;
            $nameMatch = str_contains(strtolower($item['name']), strtolower($query));
            $subMatch = str_contains(strtolower($item['subtitle']), strtolower($query));
            $catMatch = str_contains(strtolower($item['category']), strtolower($query));
            return $nameMatch || $subMatch || $catMatch;
        })->values()->all();

        // Gabungkan hasil
        $finalData = array_merge($results, $localMatches);

        return response()->json([
            'status' => 'success',
            'query' => $query,
            'source' => count($results) > 0 ? 'api_ninjas + local' : 'local',
            'count' => count($finalData),
            'data' => $finalData
        ]);
    }
}
