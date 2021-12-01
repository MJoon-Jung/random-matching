/* 'production' 빌드 인경우 플러그인 적용 */
module.exports = {
    plugins: process.env.MIX_APP_ENV === 'local' ? [] : ['transform-remove-console']
}
