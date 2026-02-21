-- 1. Teacher Table (Manually populated, no signup)
CREATE TABLE teachers (
    teacher_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- 2. Student Table (Supports signup)
CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    neb_symbol_no VARCHAR(20) UNIQUE, -- From your proposal details
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- 3. Exams Table (Created by Teachers)
CREATE TABLE exams (
    exam_id INT PRIMARY KEY AUTO_INCREMENT,
    teacher_id INT,
    exam_title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
);

-- 4. Questions Table (Written type questions)
CREATE TABLE questions (
    question_id INT PRIMARY KEY AUTO_INCREMENT,
    exam_id INT,
    question_text TEXT NOT NULL,
    max_marks INT DEFAULT 10,
    FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE
);

-- 5. Submissions Table (Links student to an exam)
CREATE TABLE submissions (
    submission_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    exam_id INT,
    status ENUM('pending', 'graded') DEFAULT 'pending',
    total_score INT DEFAULT 0,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (exam_id) REFERENCES exams(exam_id)
);

-- 6. Answers Table (The written response for each specific question)
CREATE TABLE student_answers (
    answer_id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT,
    question_id INT,
    answer_text TEXT,
    marks_awarded INT DEFAULT 0,
    FOREIGN KEY (submission_id) REFERENCES submissions(submission_id),
    FOREIGN KEY (question_id) REFERENCES questions(question_id)
);

INSERT INTO teachers (full_name, email, password) 
VALUES ('Ram Sharma', 'ram@abcedu.np', 'password123');
