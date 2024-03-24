// https://github.com/alextheme/gulp_for_wp/tree/main


import gulp from 'gulp';
import yargs from 'yargs';
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import imagemin from 'gulp-imagemin';
import { deleteAsync } from 'del';
import webpack from 'webpack-stream';
import named from 'vinyl-named';
import browserSync from "browser-sync";
import zip from "gulp-zip";
import info from "./package.json" assert { type: "json" };
import replace from "gulp-replace";
import wpPot from "gulp-wp-pot";
const { src, dest, watch, series, parallel } = gulp;
const sass = gulpSass(dartSass);
import svgSprite from "svg-sprite";
import run from "gulp-run";
import ttf2woff2 from "gulp-ttf2woff2";
import fonter from "gulp-fonter";

const PRODUCTION = yargs(process.argv).parse().hasOwnProperty('prod');

const host = 'http://localhost/yaba/'

export const font = () => {
    // https://ru.stackoverflow.com/questions/1506314/%D0%9F%D1%8B%D1%82%D0%B0%D1%8E%D1%81%D1%8C-%D1%81%D0%B4%D0%B5%D0%BB%D0%B0%D1%82%D1%8C-%D0%BA%D0%BE%D0%BD%D0%B2%D0%B5%D1%80%D1%82%D0%B5%D1%80-%D1%88%D1%80%D0%B8%D1%84%D1%82%D0%BE%D0%B2-%D0%B8%D0%B7-%D0%BF%D0%BB%D0%B0%D0%B3%D0%B8%D0%BD%D0%BE%D0%B2-gulp-%D0%BD%D0%BE-%D0%BD%D0%B5-%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D0%B0%D0%B5%D1%82-%D1%81%D0%BA%D1%80%D0%B8%D0%BF%D1%82

    return src('src/fonts/*.ttf')
        .pipe(fonter({
            subset: [66,67,68, 69, 70, 71],
            formats: ['woff', 'ttf']
        }))
        .pipe(ttf2woff2())
        .pipe(dest('assets/fonts'));
}

export const sprite = done => {
    // https://madecurious.com/curiosities/generating-svg-sprites-the-easy-way/
    const srcIcons = 'src/images/icons/individual-icons/*.svg';
    const destSprite = 'assets/images/icons';
    const spriteName = 'sprite.svg';
//     run('svg-sprite -s --symbol-dest '+ destSprite +' --symbol-sprite '+ spriteName +' '+ src ).exec();
    run('svg-sprite -s --symbol-dest '+ destSprite +' --symbol-sprite '+ spriteName +' --symbol-example true --symbol-example-dest index.html '+ srcIcons).exec();

    done();
}

export const styles = () => {
    return src(['src/scss/bundle.scss', 'src/scss/admin.scss'])
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulpif(PRODUCTION, postcss([ autoprefixer ])))
        .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(dest('assets/css'))
        .pipe(server.stream());
}

export const images = () => {
    return src([
        'src/images/**/*.{jpg,jpeg,png,svg,gif}',
        '!src/images/icons/individual-icons',
        '!src/images/icons/individual-icons/**/*',
        '!src/images/icons/sprite.svg'
    ])
        .pipe(gulpif(PRODUCTION, imagemin()))
        .pipe(dest('assets/images'));
}

export const copy = () => {
    return src([
        'src/**/*',
        '!src/{images,js,scss}',
        '!src/{images,js,scss}/**/*',
        '!src/images/icons/individual-icons',
        '!src/images/icons/individual-icons/**/*',
        '!src/images/icons/sprite.svg',
        '!src/images/icons/index.html',
        '!src/fonts',
        '!src/fonts/**/*',
    ])
        .pipe(dest('assets'));
}

export const clean = async (cb) => {
    await deleteAsync(['assets/**/*']);
    cb();
}

export const scripts = () => {
    //return src('src/js/bundle.js')
    return src(['src/js/bundle.js','src/js/admin.js'])
        .pipe(named())
        .pipe(webpack({
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: ['@babel/preset-env']
                            }
                        }
                    }
                ]
            },
            mode: PRODUCTION ? 'production' : 'development',
            devtool: !PRODUCTION ? 'eval-source-map' : false,
            output: {
                filename: '[name].js'
            },
            externals: {
                jquery: 'jQuery'
            },
        }))
        .pipe(dest('assets/js'));
}



export const watchForChanges = () => {
    watch('src/scss/**/*.scss', styles);
    watch('src/images/**/*.{jpg,jpeg,png,svg,gif}', series(images, reload));
    watch(['src/**/*', '!src/images/icons/index.html', '!src/{images,js,scss}','!src/{images,js,scss}/**/*'], series(copy, reload));
    watch('src/js/**/*.js', series(scripts, reload));
    watch('src/images/icons/individual-icons', series(sprite, reload));
    watch("**/*.php", reload);
}


const server = browserSync.create();
export const serve = done => {
    server.init({
        proxy: host // put your local website link here
    });
    done();
};
export const reload = done => {
    server.reload();
    done();
};


export const compress = () => {
    return src([
        "**/*",
        "!node_modules{,/**}",
        "!bundled{,/**}",
        "!src{,/**}",
        "!.babelrc",
        "!.gitignore",
        "!gulpfile.babel.js",
        "!package.json",
        "!package-lock.json",
        "!__info.md",
        "!_info.md",
    ])
        .pipe(replace("_themename", info.name))
        .pipe(
            gulpif(
                file => file.relative.split(".").pop() !== "zip",
                replace("_themename", info.name)
            )
        )
        .pipe(zip(`${info.name}.zip`))
        .pipe(dest('bundled'));
};
export const pot = () => {
    return src("**/*.php")
        .pipe(
            wpPot({
                domain: "_themename",
                package: info.name
            })
        )
        .pipe(dest(`languages/${info.name}.pot`));
};




export const dev = series(clean, parallel(sprite, font, styles, images, copy, scripts), serve, watchForChanges);
export const build = series(clean, parallel(sprite, font, styles, images, copy, scripts), pot, compress);

export default dev;

