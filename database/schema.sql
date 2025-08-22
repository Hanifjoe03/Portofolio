-- Create database
CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

-- Admin table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Projects table
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    image_url VARCHAR(255),
    github_url VARCHAR(255),
    live_url VARCHAR(255),
    technologies TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Skills table
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(100),
    proficiency INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Experience table
CREATE TABLE experience (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    company VARCHAR(255),
    location VARCHAR(255),
    start_date DATE,
    end_date DATE,
    description TEXT,
    responsibilities TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO admin (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert your projects
INSERT INTO projects (title, description, category, technologies) VALUES
('Graphic CV Design', 'Professional CV design with modern graphics and layout', 'Design', 'Adobe Illustrator, Photoshop'),
('Web CV HTML', 'Responsive web-based curriculum vitae', 'Web Development', 'HTML, CSS, JavaScript, Tailwind CSS'),
('Animated CV', 'Interactive and animated curriculum vitae presentation', 'Animation', 'After Effects, HTML, CSS'),
('Logo Design Portfolio', 'Collection of logo designs for various clients', 'Design', 'Adobe Illustrator, Photoshop'),
('Video Profile', 'Professional video profile and portfolio showcase', 'Video', 'Adobe Premiere Pro, After Effects'),
('SMAN 2 Kota Magelang Website', 'Website design for SMAN 2 Kota Magelang', 'Web Design', 'Figma, UI/UX'),
('STMIK Bipa Design', 'Complete website design for STMIK Bipa', 'Web Design', 'Figma, UI/UX'),
('Develop with Atlas', 'Agent broker platform design', 'Web Design', 'Figma, UI/UX'),
('Secure Service Agreement Form', 'Digital form design and implementation', 'Web Development', 'HTML, CSS, JavaScript');
