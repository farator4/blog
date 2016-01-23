Within the download package you will find a folder called source. This folder contains all modules of the Zozo Tabs divided into multiple small CSS files. This makes easier to customize your build of Zozo Tabs to modify, include or remove certain modules such as vertical, underlined, multiline, responsive etc.  

The stylesheet zozo.tabs.core.css is the first and most important core-file of Zozo Tabs. This stylesheet is required for every Tabs and should not be changed! There are also two more stylesheets (zozo.tabs.horizontal.css and zozo.tabs.vertical.css) which are very important and should not be changed. But one of them is required to use tabs. All these three files contain the structure and layout of Zozo Tabs.

To get started, include the core file with horizontal or/and vertical and include any other CSS files that you need. Each individual file contains basic instructions for easy customization and modification.

For example, you use top-left horizontal tabs with white theme. In that case you include the following files:
- zozo.tabs.core.css
- zozo.tabs.horizontal.css (modified version which includes just top-left position)
- zozo.tabs.themes.css (modified version which includes just white theme)


Please note that the source CSS files are for advanced users such as developers and designer who can edit it. 

Once you have included and modified your CSS to your needs, it’s recommended to combine and minify it into single file for faster loading page time on production website. 

In the past we received a lot questions about the CSS file, such as how to modify css style and more importantly delete unnecessary style that you’re not using in your page.  It's a very common scenario for designers and developers that need additional control over tabs look and feel and performance. 


source
 ├── core
  │   ├── zozo.tabs.core.css
  │   ├── zozo.tabs.horizontal.css
  │   └── zozo.tabs.vertical.css
  └── modules 
      ├── zozo.tabs.themes.css
	  ├── zozo.tabs.clean.css
      ├── zozo.tabs.underlined.css
      ├── zozo.tabs.multiline.css
      ├── zozo.tabs.responsive.css
      ├── zozo.tabs.mobile.css
      └── zozo.tabs.grid.css
