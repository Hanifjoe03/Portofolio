<?php
require_once 'config/database.php';

// Fetch projects
$stmt = $pdo->query('SELECT * FROM projects ORDER BY id DESC');
$projects = $stmt->fetchAll();

// Fetch skills
$stmt = $pdo->query('SELECT * FROM skills ORDER BY id DESC');
$skills = $stmt->fetchAll();

// Fetch experience
$stmt = $pdo->query('SELECT * FROM experience ORDER BY id DESC');
$experiences = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanif - Portfolio & Internship Experience</title>
    <link href="output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-900">

    <!-- Header -->
    <header class="bg-white fixed top-0 left-0 w-full flex items-center z-10 shadow-sm">
        <div class="container mx-auto">
            <div class="flex items-center justify-between relative">
                <div class="px-4 flex items-center">
                    <img src="admin/uploads/logo.png" alt="Logo" class="w-10 h-10 mr-2">
                    <a href="#home" class="font-bold text-lg text-blue-600 block py-6">Hanif Portfolio</a>
                </div>
                <div class="flex items-center px-4">
                    <nav class="hidden md:block">
                        <ul class="flex space-x-8">
                            <li><a href="#home" class="text-gray-800 hover:text-blue-600">Home</a></li>
                            <li><a href="#about" class="text-gray-800 hover:text-blue-600">About</a></li>
                            <li><a href="#skills" class="text-gray-800 hover:text-blue-600">Skills</a></li>
                            <li><a href="#experience" class="text-gray-800 hover:text-blue-600">Experience</a></li>
                            <li><a href="#projects" class="text-gray-800 hover:text-blue-600">Projects</a></li>
                            <li><a href="#contact" class="text-gray-800 hover:text-blue-600">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="pt-32 pb-12 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-5xl mx-auto text-center px-4">
            <img src="dist/img/profil.png" alt="Hanif" class="w-32 h-32 mx-auto rounded-full shadow-xl mb-6 object-cover border-4 border-white">
            <h1 class="text-5xl font-bold mb-3">Hanif</h1>
            <h2 class="text-2xl text-blue-600 font-semibold mb-4">Frontend Developer & Designer</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto mb-8">
                Passionate about creating beautiful and functional web experiences. Currently completing my internship at a creative technology company.
            </p>
            <div class="flex justify-center gap-4">
                <a href="cv.pdf" download class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1">
                    Download CV
                </a>
                <a href="#contact" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-gray-50 transition transform hover:-translate-y-1 border-2 border-blue-600">
                    Contact Me
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">About Me</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
            </div>
            <p class="text-lg text-gray-700 leading-relaxed text-center">
                I am a dedicated <span class="font-semibold text-blue-600">Frontend Developer</span> and
                <span class="font-semibold text-blue-600">UI/UX Designer</span> with a passion for creating engaging digital experiences.
            </p>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-20 bg-blue-50">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Skills & Technologies</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($skills as $skill): ?>
                    <div class="mb-4">
                        <h3 class="font-semibold"><?= htmlspecialchars($skill['name']) ?></h3>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width:<?= (int)$skill['level'] ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="py-20">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Internship Experience</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <?php foreach ($experiences as $exp): ?>
                    <div>
                        <h3 class="font-bold">
                            <?= htmlspecialchars($exp['position']) ?> – <?= htmlspecialchars($exp['company']) ?>
                        </h3>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($exp['duration']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- Projects Section -->
    <section id="projects" class="py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">My Projects</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <?php foreach ($projects as $project): ?>
                    <div class="border rounded-lg overflow-hidden shadow-md">
                        <?php if (!empty($project['image'])): ?>
                            <img src="uploads/<?= htmlspecialchars($project['image']) ?>"
                                alt="<?= htmlspecialchars($project['title']) ?>"
                                class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 flex items-center justify-center bg-gray-100 text-gray-400">
                                No Image
                            </div>
                        <?php endif; ?>
                        <div class="p-4">
                            <h3 class="font-bold"><?= htmlspecialchars($project['title']) ?></h3>
                            <p class="text-sm text-gray-500"><?= htmlspecialchars($project['category']) ?></p>
                            <p><?= htmlspecialchars($project['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

    <!-- Contact Me Section -->
    <section id="contact" class="py-16 bg-gray-50">
        <div class="max-w-5xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">📩 Get In Touch</h2>
            <p class="text-gray-600 mb-8">
                Feel free to reach out if you’d like to collaborate or just say hi.
            </p>

            <form action="send_message.php" method="POST" class="max-w-xl mx-auto space-y-4">
                <input type="text" name="name" placeholder="Your Name"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required>
                <input type="email" name="email" placeholder="Your Email"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required>
                <textarea name="message" rows="5" placeholder="Your Message"
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required></textarea>
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    Send Message
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 mt-12">
        <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm">&copy; <?= date('Y'); ?> My Portfolio. All rights reserved.</p>

            <div class="flex space-x-5 mt-4 md:mt-0">
                <?php
                $stmt = $pdo->query("SELECT * FROM footer_links");
                $links = $stmt->fetchAll();
                foreach ($links as $l): ?>
                    <a href="<?= htmlspecialchars($l['url']); ?>" target="_blank" class="hover:text-white">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <?= $l['icon']; ?>
                        </svg>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </footer>


</body>

</html>