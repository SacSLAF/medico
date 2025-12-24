/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./views/**/*.php",
    "./controllers/**/*.php", 
    "./includes/**/*.php",
    "./classes/**/*.php",
    "./public/**/*.php",
    "./*.php"
  ],
  theme: {
    extend: {
      colors: {
        primary: '#3B82F6',
        secondary: '#10B981',
        danger: '#EF4444',
        warning: '#F59E0B',
        dark: '#1F2937'
      }
    },
  },
  plugins: [],
}

