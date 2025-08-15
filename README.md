# ⚙️ Repair API — Laravel Backend

The **Repair API** is the backend service for the **Repair App (Flutter frontend)**.  
It handles user authentication, repair report management, job tracking, messaging, and feedback.  
Built with **Laravel** and secured with **Laravel Sanctum**.

---

## 📌 Features

- **User Authentication** — Register, log in, log out (Laravel Sanctum).
- **Profile Management** — Update user details, change password, upload profile photo.
- **Repair Reports**  
  - Create, update, delete, and fetch reports.
  - **Report Status Workflow:**
    - `waiting` — Report created, waiting for specialist response.
    - `accepted` — Specialist accepted the job.
    - `rejected` — Specialist declined the job.
    - `escalated` — Sent to another specialist for handling.
    - `inprogress` — Job currently being worked on.
    - `completed` — Job finished by specialist.
  - Users can delete reports if its in the stage if waiting, rejected or escalated.
- **Feedback System** — Once a report is marked as `completed`, the user can submit feedback about the specialist (rating, comments).
- **Location Data** — Stores coordinates and location names for reports (works with OpenStreetMap/Nominatim frontend search).
- **Job Progress Tracking** — Upload images and comments for repair progress.
- **Messaging System** — Send and receive messages between users and specialists.
- **Account Management** — Delete account and all associated data.

---

## 🛠️ Tech Stack

- **Framework:** Laravel
- **Authentication:** Laravel Sanctum
- **Database:** MySQL
- **Image Handling:** Laravel file storage (public disk)
- **API Format:** JSON (RESTful)
