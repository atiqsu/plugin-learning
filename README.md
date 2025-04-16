# Update the README again to include a detailed "How to Run This Plugin" section

detailed_instructions = """

## ▶️ How to Run This Plugin (Step-by-Step)

Follow these steps to get the plugin running in your local WordPress environment:

### 1. 🧩 Copy Plugin Folder
        
        * Place the entire `my-react-plugin` folder into your WordPress plugins directory:
            
                         wp-content/plugins/my-react-plugin/

### 2. 📦 Install Node Dependencies

      Navigate into the plugin directory via terminal:
      
        * cd wp-content/plugins/my-react-plugin
                   
                   npm install

      This will install all required packages defined in package.json.

**3. 🛠️ Build Assets**
   
    * Use the following command to compile JavaScript and SCSS:

                npx webpack
      
    * For development mode with auto rebuild:

              npx webpack --watch

**5. ✅ Activate Plugin**
      
      1. Go to your WordPress Admin Dashboard:
      
      2. Navigate to Plugins > Installed Plugins
      
      3. Find My React Plugin
      
      4. Click Activate

**6. 🧪 Use in WordPress**
      
      1. Admin Area: Go to React Plugin in the sidebar to see the React-based dashboard.
      
      2. Frontend: Add this shortcode to any post/page to render the React form: **[react_user_form]**.

