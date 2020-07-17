<?php



    // test flex content based block

    // Every time We want t a block, we define it here
    add_action( 'acf/init', 'my_acf_init' );

    function my_acf_init() {
        // Bail out if function doesn’t exist.
        if ( ! function_exists( 'acf_register_block' ) ) {
            return;
        }

        // 1) Define each block. Below the
        acf_register_block( array(
            'name'            => 'testflex',
            'title'           => __( 'Test Flex', 'your-text-domain' ),
            'description'     => __( 'A custom example block.', 'your-text-domain' ),
            'render_callback' => 'acf_block_testflex', // see matching function below
            'category'        => 'formatting',
            'icon'            => 'admin-comments',
            'keywords'        => array( 'flex' ),
        ) );
    }

    // -----------------------------
    // Block rendering functions (similar to template php files)
    // -----------------------------


    //testflex block . $is_preview is true is for editors previewing content in realtime ( before publishing/updating)
    function acf_block_testflex( $block, $content = '', $is_preview = false ) {
        $context = Timber::context();

        // Store block values.
        $context['block'] = $block;

        // Store field values.
        $context['fields'] = get_fields();

        // Store $is_preview value.
        $context['is_preview'] = $is_preview;

        // Render the block.
        Timber::render( 'block/testflex.twig', $context );
    }
