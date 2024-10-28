/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "index.php",
    "auxiliar/*.{html,js,php}",
    "departamentos/*.{html,js,php}",
    "empleados/*.{html,js,php}",
    "usuarios/*.{html,js,php}"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
