<?php
add_action( 'vc_before_init', 'the1_question_answer_integrateWithVC' );
function the1_question_answer_integrateWithVC() {
    if (function_exists('vc_map')){
        vc_map( array(
            "name" => __( "Themes1 Question/Answer", "themes1-mnml-core" ),
            "base" => "the1_question_answer",
            "class" => "",
            "category" => __( 'ThemesOne', 'themes1-mnml-core' ),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => 'Is it a question or an answer?',
                    "param_name" => "question_or_answer",
                    "value" => array( 'Question' => 'question', 'Answer'=> 'answer' ),
                    "admin_label" => true,
                   ),
                array(
                    "type" => "textarea",
                    "class" => "",
                    "heading" => 'Type your question or answer here',
                    "param_name" => "question_answer_paragraph",
                    "value" => "",
                    "admin_label" => true,
                   ),
            ),
        )
    );
    }
}

function the1_question_answer_func( $atts ) {
    extract(shortcode_atts(array(
            'question_or_answer'  => '',
            'question_answer_paragraph'  => '',
        ), $atts));
        $output = "";
        $question_or_answer = ( $question_or_answer ? $question_or_answer : 'question' );

        $output .= '<span class="'.esc_attr($question_or_answer).'">';
        $output .= $question_answer_paragraph;
        $output .= '</span>';
        
        
        return $output;
}
add_shortcode( 'the1_question_answer', 'the1_question_answer_func' );

?>