/** @type {import('vls').VeturConfig} */
module.exports = {
  settings: {
    "vetur.useWorkspaceDependencies": true,
    "vetur.experimental.templateInterpolationService": true
  },
  projects: [
    './frontend', // shorthand for only root.
    {
      root: './frontend',
      package: './frontend/package.json',
      tsconfig: './frontend/tsconfig.json'
    }
  ]
}
