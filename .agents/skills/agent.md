# Custom WordPress Ecosystem & Automation Workflow

## 1. Project Overview & Architecture
- **Project Type:** Advanced Custom WordPress Ecosystem.
- **Scope of Authority:** The AI is authorized to manage the ENTIRE WordPress system. This includes modifying codebase files, executing database operations, managing plugins, and publishing content via the WordPress Admin dashboard.
- **Architecture Stack:** WooCommerce, ACF JSON (`acf-json/`), Composer (`vendor/`), NPM (`node_modules/`).

## 2. The Golden Rule: The Migration Guide
- **Process & Structure:** For any major changes or new project setups, the AI **MUST** first read `WORDPRESS-MIGRATION-GUIDE.md` in the root directory. 
- **Documentation Standard:** Use `WORDPRESS-MIGRATION-GUIDE.md` as the exact template and standard for formatting any future `.md` files or documentation.

## 3. Live WordPress Interaction & Automation (CRITICAL)
The AI is expected to actively manage the live WordPress site using the following methods:

- **Method A: WP-CLI (Primary for Admin Tasks)**
  - Use `wp-cli` via the terminal (`run_command`) for all standard admin operations because it is the fastest and most reliable method.
  - *Examples:* `wp plugin install <name> --activate`, `wp post create`, `wp search-replace`, `wp option update`.
  - Always verify that WP-CLI is installed and accessible in the environment before running commands.

- **Method B: Browser Automation (Primary for Content & UI)**
  - For tasks requiring visual interaction (e.g., using the Gutenberg Block Editor, filling out Advanced Custom Fields, or configuring plugin UI settings), use Puppeteer tools or the `/browser` capability.
  - Navigate to `/wp-admin`, log in using the provided local development credentials, and interact with the UI exactly as a human Content Manager would.

## 4. Standard WordPress Configuration & Baseline Plugins
When setting up a new project or verifying an environment, the AI must ensure the following baselines are met (preferably using WP-CLI):

- **Core Settings:**
  - **Permalinks:** Must be set to Post Name (`/%postname%/`). Run `wp rewrite structure '/%postname%/' --hard` and flush rewrite rules.
  - **Reading Settings:** Set a static front page (Home) and a posts page (Blog). Ensure "Discourage search engines" is UNCHECKED for production sites.
  - **General Settings:** Update the Site Title, Tagline, and Admin Email to match the specific brand guidelines for the current project.
  - **Timezone & Date:** Set the appropriate local timezone and standard date/time formatting.

- **Required Baseline Plugins:**
  - Ensure the core stack is always installed, activated, and updated. This includes (but is not limited to):
    - **WooCommerce** (if an e-commerce site)
    - **Advanced Custom Fields (ACF)** (for custom data structures)
    - **SEO Plugin** (e.g., Yoast SEO or RankMath)
    - **Security/Performance Plugins** (as defined in the `WORDPRESS-MIGRATION-GUIDE.md`)

## 5. Git Workflow & Commits (MANDATORY)
- **Feature & Fix Commits:** The AI must **ALWAYS** create a Git commit immediately after a GitHub issue is fixed, or when a new feature is successfully added and verified.
- Do not stack massive changes without committing. Keep commits logical and tied to specific features or fixes.
- Before starting new work, always ensure you are on the correct branch and the working directory is clean.

## 6. Development Rules for AI (Antigravity)
- **ACF Sync:** Always respect the `acf-json` folder. If filling out forms via the browser changes the ACF schema, ensure the JSON files are committed to Git.
- **WooCommerce:** Any modifications to WooCommerce templates must be done safely within the `woocommerce/` override folder.
- **Dependencies:** Use Composer for PHP packages and NPM for frontend tools. Never modify the `vendor/` or `node_modules/` folders directly.
