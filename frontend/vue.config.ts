module.exports = {
  // ポートなどの設定
  devServer: {
    port: 8080,
    proxy: {
      '/api': {
        target: 'http://localhost:8000/api',
        https: false
      }
    }
  }
}
