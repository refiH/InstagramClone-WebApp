/** @type {import('tailwindcss').Config} */
export default {
  content: ['./resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'],
  theme: {
    extend: {
      fontFamily: {
        display: ['"Staatliches"', 'sans-serif'],
        body: ['"Nunito Sans"', 'sans-serif'],
      },
      colors: {
        light: '#f8f8ff',
        dark: '#1c1c1c',
        primary: '#60A5FA',
        'primary-dark': '#3B82F6',
      },
    },
  },
  plugins: [],
};
