<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>FarmLift - Authentication</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "brand-yellow": "#FFF799",
                        "error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#254778",
                        "tertiary": "#205200",
                        "surface-bright": "#faf9fe",
                        "primary-fixed": "#d6e3ff",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-fixed": "#082100",
                        "surface-container": "#eeedf2",
                        "on-tertiary-fixed-variant": "#1f5100",
                        "surface-variant": "#e3e2e7",
                        "on-secondary-container": "#003971",
                        "inverse-on-surface": "#f1f0f5",
                        "on-surface": "#1a1c1f",
                        "tertiary-fixed-dim": "#98d772",
                        "primary-fixed-dim": "#a9c7ff",
                        "secondary": "#015eb3",
                        "on-error-container": "#93000a",
                        "on-tertiary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "tertiary-fixed": "#b3f48b",
                        "primary-container": "#406093",
                        "on-error": "#ffffff",
                        "surface-tint": "#3f5f92",
                        "surface-container-high": "#e8e7ec",
                        "primary": "#26487a",
                        "on-primary": "#ffffff",
                        "error": "#ba1a1a",
                        "secondary-container": "#67a4fe",
                        "on-tertiary-container": "#abec84",
                        "secondary-fixed-dim": "#a8c8ff",
                        "surface-container-highest": "#e3e2e7",
                        "on-surface-variant": "#43474f",
                        "on-secondary-fixed-variant": "#004689",
                        "on-secondary-fixed": "#001b3c",
                        "surface-container-low": "#f4f3f8",
                        "surface": "#faf9fe",
                        "outline-variant": "#c3c6d0",
                        "outline": "#747780",
                        "on-primary-container": "#c9dbff",
                        "on-primary-fixed": "#001b3d",
                        "background": "#faf9fe",
                        "tertiary-container": "#346c13",
                        "on-background": "#1a1c1f",
                        "surface-dim": "#dad9de",
                        "inverse-primary": "#a9c7ff",
                        "secondary-fixed": "#d5e3ff",
                        "inverse-surface": "#2f3034",
                        "driver-state": "#4C8CE4",
                        "farmer-state": "#91D06C"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        "2xl": "1.25rem",
                        "3xl": "1.5rem",
                        full: "9999px"
                    },
                    spacing: {
                        xl: "4rem",
                        gutter: "1.5rem",
                        md: "1.5rem",
                        margin: "2rem",
                        base: "4px",
                        sm: "1rem",
                        xs: "0.5rem",
                        lg: "2.5rem"
                    },
                    fontFamily: {
                        "caps-xs": ["Inter"],
                        display: ["Inter"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-sm": ["Inter"],
                        h1: ["Inter"],
                        h2: ["Inter"]
                    },
                    fontSize: {
                        "caps-xs": ["12px", { lineHeight: "1", letterSpacing: "0.05em", fontWeight: "700" }],
                        display: ["48px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "body-md": ["16px", { lineHeight: "1.6", fontWeight: "400" }],
                        "body-lg": ["18px", { lineHeight: "1.6", fontWeight: "400" }],
                        "label-sm": ["14px", { lineHeight: "1.4", letterSpacing: "0.01em", fontWeight: "500" }],
                        h1: ["32px", { lineHeight: "1.2", letterSpacing: "-0.01em", fontWeight: "600" }],
                        h2: ["24px", { lineHeight: "1.3", fontWeight: "600" }]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23406093' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .floating-shape {
            animation: float 15s ease-in-out infinite;
        }

        .floating-shape-delayed {
            animation: float 20s ease-in-out infinite alternate-reverse;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg) scale(1); }
            33% { transform: translateY(-30px) rotate(10deg) scale(1.05); }
            66% { transform: translateY(20px) rotate(-5deg) scale(0.95); }
            100% { transform: translateY(0px) rotate(0deg) scale(1); }
        }

        /* Toggle slider animation */
        .toggle-slider {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s ease;
        }

        /* Accent transition for inputs and buttons */
        .accent-transition {
            transition: border-color 0.3s ease, color 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }
    </style>
</head>
<body class="bg-[#fcfdfd] min-h-screen relative overflow-x-hidden font-body-md text-body-md text-on-surface" style="font-family: 'Inter', sans-serif;">
    @yield('content')
</body>
</html>
