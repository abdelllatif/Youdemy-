erDiagram
    users {
        int id PK
        string name
        string email
        string password
        string role "admin|teacher|student"
        string avatar
        string bio
        datetime email_verified_at
        boolean is_active
        datetime created_at
        datetime updated_at
    }

    teachers {
        int user_id PK,FK
        string expertise
        text bio
        int followers_count
        boolean is_verified
        datetime verified_at
    }

    followers {
        int id PK
        int teacher_id FK "only users with teacher role"
        int student_id FK
        datetime created_at
    }

    courses {
        int id PK
        int teacher_id FK
        int category_id FK
        string title
        string slug
        text description
        string level
        string thumbnail
        text requirements
        text learnings
        int students_count
        int likes_count
        decimal price
        boolean is_published
        datetime published_at
        datetime created_at
        datetime updated_at
    }

  



    users ||--o{ teachers : "can be"
    users ||--o{ enrollments : "can enroll"
    teachers ||--o{ followers : "can have"
    teachers ||--o{ courses : "creates"
    courses ||--o{ enrollments : "has"
    enrollments ||--o{ progress_tracking : "tracks"
    enrollments ||--o{ payment_transactions : "has"