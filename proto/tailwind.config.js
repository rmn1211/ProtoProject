module.exports = {
  purge: [],
  //darkMode: true, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    cursor: ['disabled'],
    pointerEvents: ['disabled'],
    backgroundColor: ['responsive', 'hover', 'focus', 'active', 'disabled'],
    textColor: ['responsive', 'hover', 'focus', 'active', 'disabled'],
    extend: {
      backgroundColor: ['active'],
    },
  },
  plugins: [],
}
