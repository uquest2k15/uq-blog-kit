
## Objective
현재 Git에 'as-is'와 같은 폴더 구조로 저장되어 있는데, 'to-be'같은 구조로 바꾸려고 해. 어떻게 처리하면 되지?

## as-is
```
├── docs\
└── src\
	└── wp-content\
		└──	mu-plugins\
				├── uq-custom-sitewide.php    # Main plugin file
				└── uq-custom-sitewide/
					├── assets/
					│	├── js/
					│	└── css/
					└── includes/
						├── uq-blog-kit.php           # Core blog functionality
						├── uq-gf-general.php         # General functions
						├── sidebar-cat-filter-widget.php  # Category filter widget
						└── related-posts-section.php      # Related posts feature
```

## to-be
```
├── docs/
├── uq-custom-sitewide.php    # Main plugin file
└── uq-custom-sitewide/
	├── assets/
	│	├── js/
	│	└── css/
	└── includes/
		├── uq-blog-kit.php           # Core blog functionality
		├── uq-gf-general.php         # General functions
		├── sidebar-cat-filter-widget.php  # Category filter widget
		└── related-posts-section.php      # Related posts feature
```
