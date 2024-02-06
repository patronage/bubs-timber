module.exports = {
  extends: [
    'stylelint-config-idiomatic-order',
    'stylelint-config-standard',
    'stylelint-config-standard-scss',
    'stylelint-prettier/recommended',
  ],
  fix: true,
  formatter: 'verbose',
  plugins: ['stylelint-scss'],
  rules: {
    'max-nesting-depth': 2,
    'scss/comment-no-empty': null,
    'selector-class-pattern': null,
    'selector-id-pattern': null,
    'scss/at-import-no-partial-leading-underscore': null,
    'scss/dollar-variable-pattern': null,
    'scss/no-global-function-names': null,
    'scss/at-extend-no-missing-placeholder': null,
    'declaration-block-no-redundant-longhand-properties': null,
    'color-function-notation': 'legacy',
    // simple tailwind rules: https://gist.github.com/stctheproducer/332e1171a1f4eb6647933bc8d3f8aaf6
    'at-rule-no-unknown': null,
    'scss/at-rule-no-unknown': [
      true,
      {
        ignoreAtRules: ['apply', 'layer', 'responsive', 'screen', 'tailwind', 'variants'],
      },
    ],
    'declaration-block-trailing-semicolon': null,
    'no-descending-specificity': null,
    // end simple tailwind rules
    'at-rule-empty-line-before': [
      'always',
      {
        except: ['blockless-after-same-name-blockless', 'first-nested', 'inside-block'],
        ignore: ['after-comment'],
        ignoreAtRules: ['include'],
      },
    ],
    'declaration-empty-line-before': [
      'always',
      {
        except: ['after-declaration', 'first-nested'],
        ignore: ['after-comment', 'inside-single-line-block'],
      },
    ],
    'max-empty-lines': 1,
    'rule-empty-line-before': [
      'always-multi-line',
      {
        except: ['first-nested'],
        ignore: ['after-comment'],
      },
    ],
    'scss/dollar-variable-empty-line-before': [
      'always',
      {
        except: ['after-dollar-variable', 'first-nested'],
        ignore: ['after-comment'],
      },
    ],
  },
  syntax: 'scss',
};
