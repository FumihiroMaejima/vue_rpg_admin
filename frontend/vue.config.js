module.exports = {
  publicPath: '/admin/',
  outputDir: 'dist',
  // ポートなどの設定
  devServer: {
    port: 8080,
    proxy: {
      // mock endpoint
      /* '/api': {
        target: 'http://localhost:8000/'
      } */
      '/api': {
        target: 'http://localhost/',
        https: false
      }
    }
  }
}
