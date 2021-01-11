module.exports = {
  // ポートなどの設定
  devServer: {
    port: 8080,
    proxy: {
      // mock endpoint
      '/api': {
        target: 'http://localhost:8000/api',
        https: false
      }
      /*
      '/api': {
        target: 'http://localhost/api',
        https: false
      }
      */
    }
  }
}
