const gulp = require("gulp"); //gulp本体

//scss
const sass = require("gulp-dart-sass"); //Dart Sass はSass公式が推奨 @use構文などが使える
const plumber = require("gulp-plumber"); // エラーが発生しても強制終了させない
const notify = require("gulp-notify"); // エラー発生時のアラート出力
const browserSync = require("browser-sync"); //ブラウザリロード
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");

gulp.task("default", function () {
  return gulp.src("src/test.css")
    .pipe(postcss([
      autoprefixer({
        browsers: [
            "last 2 versions", 
            "ie >= 11", 
            "Android >= 4"
        ],
        cascade: false
      })
    ]))
    .pipe(gulp.dest("benpre"));
});

// 入出力するフォルダを指定
const srcBase = "../static/html";
const assetsBase = "../assets";
const distBase = "../";

const srcPath = {
  scss: assetsBase + "/scss/**/*.scss",
  html: srcBase + "/**/*.php",
};

const distPath = {
  css: distBase + "/css/",
  html: distBase + "/",
};

/**
 * sass
 *
 */
const cssSass = () => {
  return gulp
    .src(srcPath.scss, {
      sourcemaps: true,
    })
    .pipe(
      //エラーが出ても処理を止めない
      plumber({
        errorHandler: notify.onError("Error:<%= error.message %>"),
      })
    )
    .pipe(sass({ outputStyle: "expanded" })) //指定できるキー expanded compressed
    .pipe(gulp.dest(distPath.css, { sourcemaps: "./" })) //コンパイル先
    .pipe(browserSync.stream())
    .pipe(
      notify({
        message: "Sassをコンパイルしました！",
        onLast: true,
      })
    );
};

/**
 * html
 */
const html = () => {
  return gulp.src(srcPath.html).pipe(gulp.dest(distPath.html));
};

/**
 * ローカルサーバー立ち上げ
 */
const browserSyncFunc = () => {
  browserSync.init(browserSyncOption);
};

const browserSyncOption = {
  proxy: "http://localhost:8888/auro-blog/",
  open: "true",
  watchOptions: {
    debounceDelay: 1000,
  },
  reloadOnRestart: true,
};

/**
 * リロード
 */
const browserSyncReload = (done) => {
  browserSync.reload();
  done();
};

/**
 *
 * ファイル監視 ファイルの変更を検知したら、browserSyncReloadでreloadメソッドを呼び出す
 * series 順番に実行
 * watch('監視するファイル',処理)
 */
const watchFiles = () => {
  gulp.watch(srcPath.scss, gulp.series(cssSass));
  gulp.watch(srcPath.html, gulp.series(html, browserSyncReload));
};

/**
 * seriesは「順番」に実行
 * parallelは並列で実行
 */
exports.default = gulp.series(
  gulp.parallel(html, cssSass),
  gulp.parallel(watchFiles, browserSyncFunc)
);