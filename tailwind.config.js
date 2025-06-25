export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',

  ],
  theme: {
    extend: {
      colors: {
        'thd-color-violet-90': '#4B1D78',
        'thd-color-violet-70': '#6A3F9D',
        'thd-color-violet-40': '#B28DDB',
        'thd-color-violet-30': '#D0B9ED',
        'thd-color-violet-20': '#EAE0F8',
      },
      fontFamily: {
        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      spacing: {
        'fluid-base': 'clamp(1rem, 2vw, 2rem)',
        'fluid-md': 'clamp(2rem, 4vw, 4rem)',
        'fluid-lg': 'clamp(4rem, 6vw, 6rem)',
        '4xl': '4rem',
      },
      borderRadius: {
        'thd-rounded-ext': '2rem',
      },
    },
  },
  plugins: [],
}
