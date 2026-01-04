
module.exports = {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                // رنگ‌های متنی اصلی — در هر دو تم بهترین contrast را دارند
                primary: {
                    light: 'rgb(24, 24, 27)',    // zinc-900
                    dark: 'rgb(250, 250, 250)', // zinc-50
                },
                secondary: {
                    light: 'rgb(82, 82, 91)',    // zinc-600
                    dark: 'rgb(161, 161, 170)', // zinc-400
                },
                muted: {
                    light: 'rgb(113, 113, 122)', // zinc-500
                    dark: 'rgb(115, 115, 115)', // zinc-600 (کمی روشن‌تر از معمول برای خوانایی)
                },
                accent: {
                    light: 'rgb(37, 99, 235)',   // blue-600
                    dark: 'rgb(96, 165, 250)',  // blue-400
                },
            },
            textColor: {
                primary: 'var(--color-primary)',
                secondary: 'var(--color-secondary)',
                muted: 'var(--color-muted)',
                accent: 'var(--color-accent)',
            },
        },
    },
    plugins: [
        function ({ addUtilities, theme }) {
            addUtilities({
                '.text-primary': {
                    color: theme('colors.primary.light'),
                    '@apply dark:text-primary-dark': {},
                },
                '.text-primary-dark': { color: theme('colors.primary.dark') },
                '.text-secondary': {
                    color: theme('colors.secondary.light'),
                    '@apply dark:text-secondary-dark': {},
                },
                '.text-secondary-dark': { color: theme('colors.secondary.dark') },
                '.text-muted': {
                    color: theme('colors.muted.light'),
                    '@apply dark:text-muted-dark': {},
                },
                '.text-muted-dark': { color: theme('colors.muted.dark') },
                '.text-accent': {
                    color: theme('colors.accent.light'),
                    '@apply dark:text-accent-dark': {},
                },
                '.text-accent-dark': { color: theme('colors.accent.dark') },
            });
        },
    ],
};