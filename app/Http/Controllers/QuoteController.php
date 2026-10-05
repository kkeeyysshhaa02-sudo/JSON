<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Koleksi Folder Stack Quotes (BrandAppart style)
        $folderQuotes = [
            [
                'id' => 'folder-1',
                'index' => '01',
                'category' => 'Inovasi & Visi',
                'title' => 'Inovasi membedakan antara seorang pemimpin dan pengikut.',
                'quote' => 'Waktu Anda terbatas, jadi jangan sia-siakan dengan menjalani hidup orang lain. Jangan terperangkap oleh dogma, yaitu hidup dengan hasil pemikiran orang lain. Milikilah keberanian untuk mengikuti hati dan intuisi Anda.',
                'author' => 'Steve Jobs',
                'role' => 'Co-founder Apple Inc.',
                'color' => '#E8590C',
                'bg_class' => 'bg-amber-600 text-white',
                'tag' => 'Apple / Visionary',
                'year' => '2005',
                'case_study' => 'Stanford Commencement Address',
                'accent' => '#FF922B',
                'metrics' => ['Kategori' => 'Inovasi', 'Tahun' => '2005', 'Dampak' => 'Global']
            ],
            [
                'id' => 'folder-2',
                'index' => '02',
                'category' => 'Ketabahan & Keberanian',
                'title' => 'Kita mungkin mengalami banyak kekalahan, tetapi kita tidak boleh dikalahkan.',
                'quote' => 'Anda mungkin tidak dapat mengontrol semua peristiwa yang terjadi pada Anda, tetapi Anda dapat memutuskan untuk tidak terpuruk oleh peristiwa tersebut. Temukan kekuatan dalam setiap helaan nafas.',
                'author' => 'Maya Angelou',
                'role' => 'Penyair & Aktivis Hak Sipil',
                'color' => '#2B4C7E',
                'bg_class' => 'bg-indigo-700 text-white',
                'tag' => 'Literature / Resilience',
                'year' => '1969',
                'case_study' => 'I Know Why the Caged Bird Sings',
                'accent' => '#4DABF7',
                'metrics' => ['Kategori' => 'Sastra', 'Penghargaan' => 'Pulitzer', 'Inspirasi' => 'Tinggi']
            ],
            [
                'id' => 'folder-3',
                'index' => '03',
                'category' => 'Filsafat & Imajinasi',
                'title' => 'Imajinasi lebih penting daripada pengetahuan semata.',
                'quote' => 'Pengetahuan terbatas pada apa yang kita ketahui dan pahami saat ini, sementara imajinasi merangkul seluruh dunia, merangsang kemajuan, dan melahirkan evolusi berpikir tanpa batas.',
                'author' => 'Albert Einstein',
                'role' => 'Fisikawan Teoretis',
                'color' => '#2F4F4F',
                'bg_class' => 'bg-emerald-800 text-white',
                'tag' => 'Physics / Philosophy',
                'year' => '1929',
                'case_study' => 'Cosmic Religion & Discovery',
                'accent' => '#51CF66',
                'metrics' => ['Nobel' => 'Fisika 1921', 'Relativitas' => 'E=mc²', 'Warisan' => 'Abadi']
            ],
            [
                'id' => 'folder-4',
                'index' => '04',
                'category' => 'Eksistensialisme',
                'title' => 'Jadilah dirimu sendiri; semua orang lain sudah diambil.',
                'quote' => 'Mencintai diri sendiri adalah awal dari sebuah romansa seumur hidup. Hiduplah tanpa rasa sesal dan jangan pernah biarkan standar dunia mendikte keindahan jiwamu.',
                'author' => 'Oscar Wilde',
                'role' => 'Penulis drama & Pujangga',
                'color' => '#5C3D2E',
                'bg_class' => 'bg-stone-800 text-white',
                'tag' => 'Art & Literature',
                'year' => '1890',
                'case_study' => 'The Picture of Dorian Gray',
                'accent' => '#D4A373',
                'metrics' => ['Karya' => 'Plays & Prose', 'Gaya' => 'Aesthetisisme', 'Era' => 'Victoria']
            ],
            [
                'id' => 'folder-5',
                'index' => '05',
                'category' => 'Desain & Kesederhanaan',
                'title' => 'Kesederhanaan adalah bentuk kecanggihan tertinggi.',
                'quote' => 'Kemampuan untuk menyederhanakan berarti menghilangkan hal-hal yang tidak perlu agar yang esensial dapat bersuara dengan jernih dan berdaya guna.',
                'author' => 'Leonardo da Vinci',
                'role' => 'Polimatik Era Renaisans',
                'color' => '#845EC2',
                'bg_class' => 'bg-purple-800 text-white',
                'tag' => 'Art / Mastery',
                'year' => '1500',
                'case_study' => 'Codex Atlanticus Notes',
                'accent' => '#D65DB1',
                'metrics' => ['Disiplin' => 'Sains & Seni', 'Penemuan' => '500+ Desain', 'Karya' => 'Mona Lisa']
            ]
        ];

        // Koleksi Buku di Rak (3D Interactive Bookshelf - JZA Studio style)
        $books = [
            [
                'id' => 'book-1',
                'spine_title' => 'ATOMIC HABITS',
                'title' => 'Atomic Habits',
                'subtitle' => 'Perubahan Kecil yang Memberikan Hasil Luar Biasa',
                'author' => 'James Clear',
                'spine_color' => '#FEF08A',
                'text_color' => '#1F2937',
                'cover_color' => '#EAB308',
                'height' => '320px',
                'width' => '48px',
                'font' => 'font-sans font-black tracking-widest',
                'quote' => 'Anda tidak naik ke tingkat tujuan Anda. Anda jatuh ke tingkat sistem Anda. Kualitas hidup Anda bergantung pada kualitas kebiasaan Anda sehari-hari.',
                'author_bio' => 'Penulis terlaris New York Times dan pakar pembentukan kebiasaan yang mempopulerkan konsep perbaikan 1% setiap hari.',
                'year' => '2018',
                'pages' => '320 halaman',
                'genre' => 'Self-Improvement'
            ],
            [
                'id' => 'book-2',
                'spine_title' => 'S,M,L,XL',
                'title' => 'Small, Medium, Large, Extra-Large',
                'subtitle' => 'Eksplorasi Arsitektur dan Kondisi Urban Modern',
                'author' => 'Rem Koolhaas & Bruce Mau',
                'spine_color' => '#E2E8F0',
                'text_color' => '#0F172A',
                'cover_color' => '#334155',
                'height' => '370px',
                'width' => '64px',
                'font' => 'font-mono font-extrabold tracking-tighter text-lg',
                'quote' => 'Arsitektur adalah perpaduan berbahaya antara kekuatan dan ketidakberdayaan. Kekuatan karena mengubah fisik bumi; ketidakberdayaan karena bergantung pada kehendak orang lain.',
                'author_bio' => 'Arsitek pemenang Pritzker Prize asal Belanda dan teoritikus tata ruang kontemporer.',
                'year' => '1995',
                'pages' => '1,344 halaman',
                'genre' => 'Architecture & Design'
            ],
            [
                'id' => 'book-3',
                'spine_title' => 'FILOSOFI TERAS',
                'title' => 'Filosofi Teras',
                'subtitle' => 'Filsafat Stoikisme Kuno untuk Mental Tangguh',
                'author' => 'Henry Manampiring',
                'spine_color' => '#F43F5E',
                'text_color' => '#FFFFFF',
                'cover_color' => '#BE123C',
                'height' => '340px',
                'width' => '44px',
                'font' => 'font-serif font-bold tracking-wider',
                'quote' => 'Bukan hal-hal di luar diri kita yang membuat kita cemas atau marah, melainkan penilaian dan interpretasi pikiran kita sendiri terhadap hal tersebut.',
                'author_bio' => 'Penulis Indonesia dan praktisi periklanan yang mempopulerkan ajaran Stoikisme kuno secara relevan untuk generasi modern.',
                'year' => '2018',
                'pages' => '344 halaman',
                'genre' => 'Philosophy'
            ],
            [
                'id' => 'book-4',
                'spine_title' => 'DESIGN OF EVERYDAY THINGS',
                'title' => 'The Design of Everyday Things',
                'subtitle' => 'Mengapa Produk Buruk Dibuat & Bagaimana Memperbaikinya',
                'author' => 'Don Norman',
                'spine_color' => '#3B82F6',
                'text_color' => '#FFFFFF',
                'cover_color' => '#1D4ED8',
                'height' => '330px',
                'width' => '50px',
                'font' => 'font-sans font-bold tracking-tight',
                'quote' => 'Desain yang baik sebenarnya jauh lebih sulit disadari daripada desain yang buruk, sebagian karena desain yang baik sangat cocok dengan kebutuhan kita sehingga tidak terlihat.',
                'author_bio' => 'Direktur The Design Lab di UC San Diego dan mantan VP Advanced Technology Apple.',
                'year' => '1988',
                'pages' => '368 halaman',
                'genre' => 'User Experience'
            ],
            [
                'id' => 'book-5',
                'spine_title' => 'THE COURAGE TO BE DISLIKED',
                'title' => 'Berani Tidak Disukai',
                'subtitle' => 'Fenomena dari Jepang untuk Membebaskan Diri & Bahagia',
                'author' => 'Ichiro Kishimi & Fumitake Koga',
                'spine_color' => '#10B981',
                'text_color' => '#FFFFFF',
                'cover_color' => '#047857',
                'height' => '310px',
                'width' => '44px',
                'font' => 'font-sans font-bold tracking-wider',
                'quote' => 'Keberanian untuk bahagia juga mencakup keberanian untuk tidak disukai orang lain. Ketika Anda berhenti hidup untuk memenuhi ekspektasi orang lain, kebebasan sejati dimulai.',
                'author_bio' => 'Filsuf Adlerian dan penulis Jepang terkemuka dalam bidang psikologi kepribadian.',
                'year' => '2013',
                'pages' => '280 halaman',
                'genre' => 'Psychology'
            ],
            [
                'id' => 'book-6',
                'spine_title' => 'MAN’S SEARCH FOR MEANING',
                'title' => 'Man’s Search for Meaning',
                'subtitle' => 'Menemukan Makna Hidup di Tengah Penderitaan Ekstrem',
                'author' => 'Viktor E. Frankl',
                'spine_color' => '#8B5CF6',
                'text_color' => '#FFFFFF',
                'cover_color' => '#6D28D9',
                'height' => '345px',
                'width' => '52px',
                'font' => 'font-serif font-black tracking-widest',
                'quote' => 'Segala sesuatu bisa dirampas dari manusia kecuali satu hal: kebebasan terakhir manusia — untuk memilih sikap dalam setiap situasi yang dihadapi.',
                'author_bio' => 'Neurolog dan psikiater Austria, penyintas kamp konsentrasi Auschwitz, dan pendiri Logoterapi.',
                'year' => '1946',
                'pages' => '200 halaman',
                'genre' => 'Memoir & Psychology'
            ],
            [
                'id' => 'book-7',
                'spine_title' => 'BOEKSHA • 1984',
                'title' => '1984',
                'subtitle' => 'Sebuah Karya Distopia Abadi tentang Kebebasan Pikiran',
                'author' => 'George Orwell',
                'spine_color' => '#F472B6',
                'text_color' => '#831843',
                'cover_color' => '#BE185D',
                'height' => '355px',
                'width' => '56px',
                'font' => 'font-mono font-bold tracking-widest text-xs',
                'quote' => 'Kebebasan adalah kebebasan untuk mengatakan bahwa dua ditambah dua sama dengan empat. Jika hal itu diakui, segala sesuatu yang lain akan mengikuti.',
                'author_bio' => 'Novelis dan jurnalis Inggris paling berpengaruh di abad ke-20 dengan kritik tajam terhadap totaliterianisme.',
                'year' => '1949',
                'pages' => '328 halaman',
                'genre' => 'Dystopian Classic'
            ],
            [
                'id' => 'book-8',
                'spine_title' => 'DEEP WORK',
                'title' => 'Deep Work',
                'subtitle' => 'Aturan untuk Sukses Terfokus di Dunia yang Penuh Gangguan',
                'author' => 'Cal Newport',
                'spine_color' => '#FB923C',
                'text_color' => '#431407',
                'cover_color' => '#C2410C',
                'height' => '325px',
                'width' => '46px',
                'font' => 'font-sans font-black tracking-tight',
                'quote' => 'Kemampuan untuk melakukan kerja mendalam (deep work) menjadi semakin langka justru pada saat yang sama nilainya menjadi semakin berharga dalam ekonomi kita.',
                'author_bio' => 'Profesor Ilmu Komputer di Georgetown University dan penulis spesialis produktivitas tanpa distraksi.',
                'year' => '2016',
                'pages' => '304 halaman',
                'genre' => 'Productivity'
            ]
        ];

        // Koleksi Short Quotes untuk Physics Pills (Bergerak dengan Gyro / Gerakan Laptop / Mouse)
        $physicsQuotes = [
            ['id' => 'p1', 'text' => 'Stay Hungry, Stay Foolish', 'author' => 'Steve Jobs', 'bg' => '#FF9F1C', 'color' => '#000000', 'icon' => '💡', 'full' => 'Tetaplah lapar akan ilmu dan pengalaman baru, dan tetaplah merasa bodoh agar selalu ingin belajar.'],
            ['id' => 'p2', 'text' => 'Making It Pop 🎨', 'author' => 'Paula Scher', 'bg' => '#FF6B6B', 'color' => '#FFFFFF', 'icon' => '🖌️', 'full' => 'Desain yang kuat bukan sekadar estetika, melainkan kemampuan membuat ide beresonansi dan meletup di benak pemirsa.'],
            ['id' => 'p3', 'text' => 'Thinking Systems 🌐', 'author' => 'Donella Meadows', 'bg' => '#F3C5FF', 'color' => '#3D0066', 'icon' => '🧩', 'full' => 'Anda tidak bisa memaksakan kendali penuh pada sistem yang kompleks, tetapi Anda bisa menari bersamanya.'],
            ['id' => 'p4', 'text' => 'Reframing Problems ⚡', 'author' => 'Richard Feynman', 'bg' => '#51CF66', 'color' => '#0B3A13', 'icon' => '⚡', 'full' => 'Prinsip pertama adalah Anda tidak boleh membodohi diri sendiri—dan Anda adalah orang yang paling mudah dibodohi.'],
            ['id' => 'p5', 'text' => 'Less is More 📐', 'author' => 'Mies van der Rohe', 'bg' => '#74C0FC', 'color' => '#0A2D4D', 'icon' => '📐', 'full' => 'Bentuk arsitektur yang paling murni lahir dari kejelasan struktur dan eliminasi dekorasi yang tidak perlu.'],
            ['id' => 'p6', 'text' => 'Code is Poetry 💻', 'author' => 'Matt Mullenweg', 'bg' => '#FFD43B', 'color' => '#4A3B00', 'icon' => '✨', 'full' => 'Teknologi bekerja paling baik saat menyatukan orang dan memberi mereka ruang untuk mengekspresikan kreativitas.'],
            ['id' => 'p7', 'text' => 'Prototyping 🚀', 'author' => 'IDEO Design', 'bg' => '#E5DBFF', 'color' => '#3B1E78', 'icon' => '🧪', 'full' => 'Satu prototipe bernilai seribu pertemuan. Buatlah nyata secepat mungkin untuk belajar.'],
            ['id' => 'p8', 'text' => 'Moving Rectangles ⬛', 'author' => 'Dieter Rams', 'bg' => '#A9E34B', 'color' => '#284507', 'icon' => '📱', 'full' => 'Desain yang baik adalah desain yang seminimal mungkin (Weniger, aber besser - Lebih sedikit, tapi lebih baik).'],
            ['id' => 'p9', 'text' => 'Simplicity Wins 🌿', 'author' => 'John Maeda', 'bg' => '#63E6BE', 'color' => '#083B2B', 'icon' => '🌱', 'full' => 'Kesederhanaan adalah tentang mengurangi hal yang berlebihan dan menambahkan hal yang bermakna.'],
            ['id' => 'p10', 'text' => 'Dream Without Fear 🌙', 'author' => 'Jalaluddin Rumi', 'bg' => '#FFA8A8', 'color' => '#5C0909', 'icon' => '🕊️', 'full' => 'Luka adalah tempat di mana cahaya memasuki jiwamu. Jangan takut untuk bermimpi dan terbang bebas.'],
            ['id' => 'p11', 'text' => 'Action Over Words 🎯', 'author' => 'Marcus Aurelius', 'bg' => '#D0EBFF', 'color' => '#0A3152', 'icon' => '🛡️', 'full' => 'Jangan buang waktu lagi untuk berdebat tentang seperti apa orang baik itu. Jadilah orang baik itu sekarang juga.'],
            ['id' => 'p12', 'text' => 'Iterate Daily 🔄', 'author' => 'James Clear', 'bg' => '#FFE066', 'color' => '#4C3B00', 'icon' => '🔁', 'full' => 'Kemenangan besar bukanlah peristiwa satu malam, melainkan akumulasi perbaikan kecil 1% setiap hari.'],
            ['id' => 'p13', 'text' => 'Test Everything 🧪', 'author' => 'Thomas Edison', 'bg' => '#BAC8FF', 'color' => '#1A2A6B', 'icon' => '🔬', 'full' => 'Saya belum gagal. Saya baru saja menemukan 10.000 cara yang belum berhasil.'],
            ['id' => 'p14', 'text' => 'Never Stop Learning 📚', 'author' => 'Socrates', 'bg' => '#FCC2D7', 'color' => '#540827', 'icon' => '📖', 'full' => 'Satu-satunya kebijaksanaan sejati adalah mengetahui bahwa Anda sebenarnya tidak tahu apa-apa.']
        ];

        return view('welcome', [
            'folderQuotes' => $folderQuotes,
            'books' => $books,
            'physicsQuotes' => $physicsQuotes
        ]);
    }
}

