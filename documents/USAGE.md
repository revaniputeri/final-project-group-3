# Installation Guide

This application uses Microsoft SQL Server as its database. Please follow these steps to set up the application:

1. **SQL Server Setup**
   - Ensure you have Microsoft SQL Server installed and running on your system
   - Create a new database named 'prestac'

2. **Clone the Repository**
   ```bash
   git clone https://github.com/your-repo/final-project-group-3.git
   ```

3. **Navigate to Project Directory**
   ```bash
   cd final-project-group-3/app
   ```

4. **Install Dependencies**
   ```bash
   composer dump-autoload
   composer update
   ```

5. **Configure Database Connection**
   - Open `config.php` in the app directory
   - Change the 'host' value to your SQL Server instance name
   - Set the 'username' and 'password' for your SQL Server authentication

6. **Laragon Setup**
   - Install Laragon if not already installed
   - Turn on 'Auto Create Virtual Hosts' in Laragon settings
   - Ensure Laragon is running

7. **Virtual Host Configuration**
   - Open the file and ensure the DocumentRoot path includes `/app` at the end (e.g., `DocumentRoot "C:/path/to/final-project-group-3/app"`)
   - This file should have been automatically created by Laragon

After completing these steps, you should be able to access the application at `http://final-project-group-3.test` in your web browser.
