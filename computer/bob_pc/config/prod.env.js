'use strict'
const apiConfig = require('./api')

module.exports = {
  NODE_ENV: '"production"',
  API_BASE_URL: `"${apiConfig.baseURL}"`
}
