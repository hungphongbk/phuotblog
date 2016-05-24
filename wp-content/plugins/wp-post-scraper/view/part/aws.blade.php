<div id="aws-credential-section">
    <h4>AWS Credentials</h4>
    @if(!$aws_exists)
        <form action="options.php" method="POST">
            {{ settings_fields('wp-post-scraper-settings-group') }}
            {{ do_settings_sections('wp-post-scraper-settings-group') }}
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Access Key</th>
                    <td>
                        <input type="text" name="aws-credentials-access-key"
                               value="{{ esc_attr(get_option('aws-credentials-access-key')) }}" size="50">
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Secret</th>
                    <td>
                        <input type="text" name="aws-credentials-secret"
                               value="{{ esc_attr(get_option('aws-credentials-secret')) }}" size="50">
                    </td>
                </tr>
            </table>
            {{ submit_button() }}
        </form>
    @else
        <p>AWS Credentials has been saved. If you want to change them, <a href="#"
                                                                          onclick="revealAwsForm('{{ WPPostScraper::getAction('aws_form') }}');">click
                here to
                reveal a form.</a></p>
    @endif
</div>