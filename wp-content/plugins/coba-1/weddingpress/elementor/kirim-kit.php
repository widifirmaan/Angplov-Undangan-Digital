<?php

namespace WeddingPress\elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
Use Elementor\Core\Schemes\Color;
Use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WeddingPress_Widget_Kirim_Kit extends Widget_Base {

    public function get_name() {
        return 'weddingpress-kirim-kit';
    }

    public function get_title() {
        return __( 'Kirim Kit', 'weddingpress' );
    }

    public function get_icon() {
        return 'elkit_icon eicon-kit-details';
    }

    public function get_categories() {
        return [ 'weddingpress' ];
    }

    public function get_style_depends() {
        return [ 'kirim-kit' ];
    }

    public function get_script_depends() {
        return [ 'kirim-kit' ];
    }

    public function get_custom_help_url() {
        return 'https://membershipdigital.com';
    }


    /**
     * Register button widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 0.1.0
     * @access protected
     */

    protected function register_controls() {
        $this->start_controls_section(
            'section_field_name',
            [
                'label' => __( 'General', 'weddingpress' ),
            ]
        );


        $this->add_control(
            'important_description',
            [
                'raw' => __( '<b>Info:</b> Link undangan, cukup ketikkan slug undangan, contoh: https://wedding.domain/send/?id=namamempelai', 'weddingpress'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'render_type'     => 'ui',
                'type'            => Controls_Manager::RAW_HTML,
            ]
        );

        $this->end_controls_section();
        
    }

    protected function render() {
        $settings = $this->get_settings();

        ?>
        
    <!--mulai dari sini-->
    <div id="__root">
    <div class="gb-notify"><div data-content="notify-message">Text berhasil di copy, silahkan pastekan di kolom chat</div></div>
    <div class="container-sm gb-container gb-space-y-6 md:gb-space-y-10">
        <div class="wrap-item form-input">
            <div class="gb-w-full">
                <div class="card">
                    <div class="card-body gb-flex-col">
                        <div class="form-group">
                            <div class="gb-mb-3">
                                <label for="contact">Silahkan Masukan Nama Tamu</label>
                                <p>* Gunakan baris baru (<kbd>&crarr;</kbd>)  untuk memisahkan nama yang akan Anda undang.</p>
                            </div>
                            <textarea name="contact" class="form-control" id="contact" cols="30" rows="5" data-content="contact" placeholder="Nama Tamu"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="gb-mb-3">
                                <label for="message">Silahkan Masukan Text Pengantar</label>
                                <p>* Isikan text ini [link-undangan] pada text pengantar agar otomatis tercantumkan link kehalaman undangan.</p>
                                <p>* Anda juga bisa menggunakan [nama] untuk menyertakan nama yang Anda undang.</p>
                            </div>
                            <textarea name="message" class="form-control" id="message" cols="30" rows="5" data-content="message" placeholder="Masukan kata pengantar"></textarea>

                        </div>

                        <div class="button-submit">
                            <button class="btn btn-success" type="button" data-content="button-submit">Buat Daftar Nama Tamu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrap-item">
            <div class="gb-w-full card ">
                <div class="card-body">
                    <div class="gb-w-full">
                        <div class="gb-mb-3">
                            <h3 class="gb-font-bold">Daftar Nama Tamu</h3>
                            <p></p>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tamu</th>
                                <th>Opsi</th>
                            </tr>
                            </thead>
                            <tbody id="body--contact" data-content="body--contact">

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<script type='text/javascript' id="guest-var">
//edit disini
    window.guestInvitationData = {
        key:'guestBookStorage-unikKey', //ini harus unik bisa menggunakan user ID, slug atau lainya,
        template: "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i [nama] untuk menghadiri acara kami.\n\n*Berikut link undangan kami*, untuk info lengkap dari acara bisa kunjungi :\n\n[link-undangan]\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n*Mohon maaf perihal undangan hanya di bagikan melalui pesan ini.*\n\nDan karena suasana masih pandemi, diharapkan untuk *tetap menggunakan masker dan datang pada jam yang telah ditentukan.*\n\nTerima kasih banyak atas perhatiannya.",
        invitationLink: "<?php echo get_home_url(); ?>/<?php echo $_GET['id']; ?>/",
    }

</script>

        <?php

    }


}