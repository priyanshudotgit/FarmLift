<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>FarmLift - Share the Space, Cut the Cost</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed-variant": "#004689",
                        "inverse-primary": "#a9c7ff",
                        "primary-fixed-dim": "#a9c7ff",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#c9dbff",
                        "on-secondary-fixed": "#001b3c",
                        "inverse-surface": "#2f3034",
                        "on-error-container": "#93000a",
                        "on-secondary": "#ffffff",
                        "surface": "#faf9fe",
                        "surface-container-high": "#e8e7ec",
                        "on-tertiary-fixed": "#082100",
                        "surface-tint": "#3f5f92",
                        "on-primary-fixed-variant": "#254778",
                        "on-secondary-container": "#003971",
                        "surface-container-lowest": "#ffffff",
                        "surface-dim": "#dad9de",
                        "outline": "#747780",
                        "on-surface": "#1a1c1f",
                        "error": "#ba1a1a",
                        "tertiary-fixed": "#b3f48b",
                        "surface-container-low": "#f4f3f8",
                        "secondary-fixed-dim": "#a8c8ff",
                        "on-tertiary-container": "#abec84",
                        "tertiary-fixed-dim": "#98d772",
                        "surface-variant": "#e3e2e7",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#f1f0f5",
                        "secondary": "#015eb3",
                        "on-surface-variant": "#43474f",
                        "error-container": "#ffdad6",
                        "primary-container": "#406093",
                        "surface-bright": "#faf9fe",
                        "background": "#faf9fe",
                        "surface-container-highest": "#e3e2e7",
                        "tertiary": "#205200",
                        "secondary-container": "#67a4fe",
                        "on-error": "#ffffff",
                        "primary-fixed": "#d6e3ff",
                        "on-background": "#1a1c1f",
                        "surface-container": "#eeedf2",
                        "tertiary-container": "#346c13",
                        "primary": "#26487a",
                        "secondary-fixed": "#d5e3ff",
                        "outline-variant": "#c3c6d0",
                        "on-primary-fixed": "#001b3d",
                        "on-tertiary-fixed-variant": "#1f5100"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "lg": "2.5rem",
                        "margin": "2rem",
                        "md": "1.5rem",
                        "sm": "1rem",
                        "base": "4px",
                        "xs": "0.5rem",
                        "xl": "4rem",
                        "gutter": "1.5rem"
                    },
                    "fontFamily": {
                        "display": ["Inter"],
                        "h1": ["Inter"],
                        "h2": ["Inter"],
                        "caps-xs": ["Inter"],
                        "body-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "display": ["48px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "h1": ["32px", { "lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "h2": ["24px", { "lineHeight": "1.3", "fontWeight": "600" }],
                        "caps-xs": ["12px", { "lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "700" }],
                        "body-md": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                        "label-sm": ["14px", { "lineHeight": "1.4", "letterSpacing": "0.01em", "fontWeight": "500" }],
                        "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .bento-shadow {
            box-shadow: 0 4px 30px rgba(0, 27, 61, 0.05);
        }
    </style>
</head>
<body class="bg-background text-on-background font-display min-h-screen flex flex-col">
    @yield('content')
</body>
</html>
