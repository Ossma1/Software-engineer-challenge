# Software-engineer-challenge

**Description:**  
This is a challenge from COD NETWORK team, aimed at testing the ability to focus on code quality, software engineering principles, and best practices.

**Technology stack:**  
This project uses **ReactJS** for the frontend and **Laravel** for the backend. The database is configured to use **MySQL**.

## Dependencies  
This project requires **Node**, **npm**, **PHP**, **MySQL**, and **Composer** installed.

## Installation  

1. First, create a `.env` file and paste the content from `.env.example` into it, or simply rename `.env.example` to `.env`. Do the same in the frontend directory. Ensure the URLs in the `.env` (frontend) have the same port as the one Laravel uses.

2. Generate the key for the Laravel project by running the following command in the root directory of the Laravel project:

   ```bash
   npm run generate:key
