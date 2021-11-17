const path = require('path')
const rootPath = path.resolve(__dirname, '../src')

module.exports = ({ config, mode }) => {

  config.resolve.alias['~'] = rootPath
  config.resolve.alias['@'] = rootPath

  // for Typescript
  config.module.rules.push({
    test: /\.ts$/,
    use: [
      {
        loader: 'ts-loader',
        options: {
          appendTsSuffixTo: [/\.vue$/],
          transpileOnly: true
        },
      }
    ],
  })

  config.module.rules.push({
    test: /\.scss$/,
    use: [
      {
        loader: 'style-loader'
      },
      {
        loader: 'css-loader',
        options: {
          modules: {
            mode: 'local',
            localIdentName: '[local]_[hash:base64:5]',
          },
        }
      },
      {
        loader: 'sass-loader'
      },
      {
        loader: 'sass-resources-loader',
        options: {
          /* resources: [
            '../src/assets/scss/*.scss',
          ], */
          resources: [
            path.resolve(__dirname, '../src/assets/scss/*.scss'),
          ],
          rootPath
        }
      },
    ]
  })

  config.resolve.modules = [
    ...(config.resolve.modules || []),
    rootPath
  ]

  return config
}
