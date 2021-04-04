const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  theme: {
    extend: {
      spacing: {
        '32.5': '8.125rem',
        '56.25': '14.0625rem',
        '14' : '2rem',
        '72': '18rem',
        '84': '21rem',
        '96': '24rem',
        '125': '32rem'
      },
      borderRadius: {
        '15': '15px'
      },
    }
  }
}