<template>
  <div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
      <div class="uk-grid uk-grid-stack uk-child-width-expand@s" uk-grid>
        <div class="uk-first-column">
          <div class="uk-grid-margin uk-first-column uk-card uk-card-default uk-card-body">
            <div uk-grid>
              <div class="uk-width-1-2@s">
                <div style="font-size: 1.5rem;">Edit News Letter Email</div>
              </div>
              <div class="uk-width-1-2@s uk-text-right">
                <div v-if="email_saved_loading" uk-spinner="ratio: 0.75"></div>
                <span v-if="email_saved && !email_saved_loading" class="uk-text-success" uk-icon="icon: check; ratio: 1.5"></span>
                <template v-if="email_saved_error && !email_saved_loading">
                  <span class="uk-text-danger" uk-icon="icon: warning; ratio: 1.5"></span> <span class="uk-text-danger">An error occurred saving the email!</span>
                </template>
              </div>
            </div>
            <div class="uk-width-1-1@s uk-margin">
              <label class="uk-form-label uk-heading-bullet" for="email_subject">Subject</label>
              <div class="uk-form-controls">
                <input type="text" class="uk-input" name="email_subject" v-model="subject" @input="update">
              </div>
            </div>
            <div class="uk-width-1-1@s uk-margin">
              <label class="uk-form-label uk-heading-bullet" for="image_url">Image</label>
              <div class="uk-form-controls">
                <div class="js-upload" uk-form-custom>
                  <input type="file" id="file" @change="uploadImage" ref="file">
                  <button class="uk-button uk-button-secondary" type="button" tabindex="-1">Upload</button>
                </div>
              </div>
              <div v-if="uploadProgress">
                <progress class="uk-progress" :value="uploadProgress" max="100"></progress>
              </div>
            </div>
            <div class="uk-width-1-1@s uk-margin">
              <label class="uk-form-label uk-heading-bullet" for="button_text">Text</label>
              <p class="uk-text uk-margin-small">The text of the email uses <a target="_blank" href="https://www.markdownguide.org/cheat-sheet/">markdown formatting <i class="fa fa-external-link" aria-hidden="true"></i></a> .</p>
              <div class="uk-form-controls">
                <textarea class="uk-textarea" rows="10" v-model="body_text" @input="update"></textarea>
              </div>
            </div>
            <div class="uk-width-1-1@s uk-margin">
              <label class="uk-form-label uk-heading-bullet" for="button_url">Button Url</label>
              <div class="uk-form-controls">
                <input type="text" class="uk-input" name="button_url" v-model="button_url" @input="update">
              </div>
            </div>
            <div class="uk-width-1-1@s uk-margin">
              <label class="uk-form-label uk-heading-bullet" for="button_text">Button Text</label>
              <div class="uk-form-controls">
                <input type="text" class="uk-input" name="button_text" v-model="button_text" @input="update">
              </div>
            </div>

            <div class="uk-padding-small">
              <hr class="uk-divider-icon uk-margin-top">
            </div>

            <div class="uk-width-1-1@s uk-margin">
              <label class="uk-form-label uk-heading-bullet" for="preview_email_address">Preview Email Address</label>
              <div class="uk-form-controls">
                <input type="text" class="uk-input" name="preview_email_address" v-model="preview_email_address" @input="update">
              </div>
            </div>

            <div class="uk-width-1-1@s uk-margin">
              <div class="" uk-grid>
                <div>
                  <button class="uk-button uk-button-primary" :disabled="!preview_email_address" @click="sendPreview">Send Preview</button>
                </div>
                <div>
                  <div v-if="preview_email_loading" uk-spinner="ratio: 0.75"></div>
                  <span v-if="preview_email_sent && !preview_email_loading" class="uk-text-success" uk-icon="icon: check; ratio: 1.5"></span>
                  <template v-if="preview_email_error && !preview_email_loading">
                    <span class="uk-text-danger" uk-icon="icon: warning; ratio: 1.5"></span> <span class="uk-text-danger">An error occurred sending the preview!</span>
                  </template>
                </div>
              </div>
            </div>

            <div class="uk-padding-small">
              <hr class="uk-divider-icon uk-margin-top">
            </div>

            <div class="uk-width-1-1@s uk-margin">
              <div class="" uk-grid>
                <div>
                  <!-- This is a button toggling the modal -->
                  <button class="uk-button uk-button-primary" uk-toggle="target: #send-all-emails" type="button">Send To Everyone</button>
                </div>
                <div>
                  <div v-if="email_blast_loading" uk-spinner="ratio: 0.75"></div>
                  <span v-if="email_blast_sent && !email_blast_loading" class="uk-text-success" uk-icon="icon: check; ratio: 1.5"></span>
                  <template v-if="email_blast_error && !email_blast_loading">
                    <span class="uk-text-danger" uk-icon="icon: warning; ratio: 1.5"></span> <span class="uk-text-danger">An error occurred sending the emails out!</span>
                  </template>
                </div>
              </div>
            </div>


            <!-- This is the modal -->
            <div id="send-all-emails" uk-modal>
              <div class="uk-modal-dialog uk-modal-body">
                <h2 class="uk-modal-title">Send Email Blast</h2>
                <p>Are you sure you want to send the email blast to everyone?</p>
                <button class="uk-button uk-button-primary uk-margin" type="button" @click="sendEmailBlast">Yes Send Email Blast</button>
                <button class="uk-button uk-modal-close" type="button">Cancel</button>
              </div>
            </div>

          </div>
        </div>
        <div class="uk-grid-margin">
          <div class="uk-width-1-1@s">
            <div class="uk-margin-top uk-margin-left uk-margin-right uk-margin-bottom uk-text-large uk-text-bold">
              {{ subject }}
            </div>
            <div v-html="markdown"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  window.Vapor = require('laravel-vapor');
  import axios from 'axios';
  export default {
    data() {
      return {
        image_url: "https://d36u81tzit3s7e.cloudfront.net/ffe8be63-1407-4f2a-8e24-4742e23db075/img/lessons/private.jpg",
        body_text: `# New Year, New Business Phone Number!\n\nI hope you all had a wonderful holiday season! My staff and I look forward to seeing you back in the pool very soon! Before we dive into 2022, I wanted to let you know we are starting off the new year with a new phone number! The Swim School now has an official business phone line and the new number is **Phone Number**.\n\nYou can reach us by either calling this number, sending a message through the “Contact Us” section of the website, or sending an email to **Email**. The previous phone number is no longer in service, so please update our contact details. In regards to our winter swim programs, private lessons for the month of January are already open for registration through the website. The first weekday session of group lessons and swim club opens for registration tomorrow Monday, January 3rd and the first weekend session of group lessons opens for registration Monday, January 10th.`,
        button_url: "https://theswimschoolfl.com/lessons",
        button_text: "Button Text",
        subject: "Email Subject",
        preview_email_address: "theswimschoolfl@gmail.com",
        uploadProgress: null,
        timeout: null,
        markdown: "",
        email_saved: false,
        email_saved_loading: false,
        email_saved_error: '',
        email_blast_sent: false,
        email_blast_loading: false,
        email_blast_error: null,
        preview_email_sent: false,
        preview_email_loading: false,
        preview_email_error: null,
      }
    },
    created() {
      this.init();
    },
    methods: {
      async uploadImage() {
        this.uploadProgress = null;
        const response = await Vapor.store(this.$refs.file.files[0], {
          visibility: 'public-read',
          progress: progress => {
            this.uploadProgress = Math.round(progress * 100);
          }
        })

        await axios.post('/emails/newsletter/upload-image', {
          uuid: response.uuid,
          key: response.key,
          bucket: response.bucket,
          name: this.$refs.file.files[0].name,
          content_type: this.$refs.file.files[0].type,
        })

        await this.init();
        this.uploadProgress = null;
      },
      debounce() {
        if (this.timeout) 
          clearTimeout(this.timeout); 

        this.timeout = setTimeout(() => {
          this.compiledMarkdown()
        }, 500); // delay
      },
      compiledMarkdown() {
        // Make an api call to get the markdown
        axios.post('/emails/newsletter/view-preview', {
          body_text: this.body_text,
          image_url: this.image_url,
          button_url: this.button_url,
          button_text: this.button_text,
          preview_email_address: this.preview_email_address,
          subject: this.subject,
        }).then(response => {
          this.markdown = response.data;
          this.save();
        });
      },
      save() {
        this.email_saved = false;
        this.email_saved_loading = true;
        this.email_saved_error = null;
        axios.post('/emails/newsletter/store', {
          body_text: this.body_text,
          image_url: this.image_url,
          button_url: this.button_url,
          button_text: this.button_text,
          preview_email_address: this.preview_email_address,
          subject: this.subject,
        }).then(() => {
          this.email_saved = true;
        }).catch((error) => {
          console.log(error);
          this.email_saved_error = error;
        }).finally(() => {
          this.email_saved_loading = false;
        });
      },
      init() {
        axios.get('/emails/newsletter/show').then(response => {
          this.body_text = response.data.configuration.body_text;
          this.image_url = response.data.configuration.image_url;
          this.button_url = response.data.configuration.button_url;
          this.button_text = response.data.configuration.button_text;
          this.subject = response.data.configuration.subject;
          this.preview_email_address = response.data.configuration.preview_email_address;
          this.compiledMarkdown();
        });
      },
      sendPreview() {
        this.preview_email_sent = false;
        this.preview_email_loading = true;
        this.preview_email_error = null;
        axios.post('/emails/newsletter/send-preview', {
            preview_email_address: this.preview_email_address,
          })
         .then(() => {
            this.preview_email_sent = true;
          }).catch((error) => {
            console.log(error);
            this.preview_email_error = error;
          }).finally(() => {
            this.preview_email_loading = false;
          });
      },
      sendEmailBlast() {
        this.email_blast_sent = false;
        this.email_blast_loading = true;
        this.email_blast_error = null;
        axios.post('/emails/newsletter/send-emails')
          .then(() => {
            this.email_blast_sent = true;
          }).catch((error) => {
            console.log(error);
            this.email_blast_error = error;
          }).finally(() => {
            this.email_blast_loading = false;
            UIkit.modal(document.getElementById('send-all-emails')).hide();
          });
      },
      update() {
        this.debounce()
      }
    }
  }
</script>
