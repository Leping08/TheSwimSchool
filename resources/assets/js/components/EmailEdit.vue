<template>
  <div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
      <div class="" uk-grid>
        <div class="uk-width-1-2@s uk-card uk-card-default uk-card-body">
          <div uk-grid>
            <div class="uk-width-1-2@s">
              <div style="font-size: 1.5rem;">Edit News Letter Email</div>
            </div>
            <div class="uk-width-1-2@s uk-text-right">
              <div v-if="loading" uk-spinner="ratio: 0.75"></div>
              <span v-if="saved && !loading" class="uk-text-success" uk-icon="icon: check; ratio: 1.5"></span>
              <span v-if="error && !loading" class="uk-text-danger" uk-icon="icon: warning; ratio: 1.5"></span>
            </div>
          </div>
          <div class="uk-width-1-1@s uk-margin">
            <label class="uk-form-label uk-heading-bullet" for="email_subject">Subject</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-input" name="email_subject" v-model="subject" @input="update">
            </div>
          </div>
          <div class="uk-width-1-1@s uk-margin">
            <label class="uk-form-label uk-heading-bullet" for="image_url">Image Url</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-input" name="image_url" v-model="image_url" @input="update">
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
          <div class="uk-width-1-1@s uk-margin">
            <label class="uk-form-label uk-heading-bullet" for="button_text">Text</label>
            <div class="uk-form-controls">
              <textarea class="uk-textarea" rows="10" v-model="body_text" @input="update"></textarea>
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
            <button class="uk-button uk-button-primary" @click="sendPreview">Send Preview</button>
          </div>
        </div>
        <div class="uk-width-1-2@s">
          <div v-html="markdown"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
        timeout: null,
        markdown: "",
        saved: false,
        loading: false,
        error: false
      }
    },
    created() {
      this.get();
      // todo: handle error on save better
      // todo: wire up button to send real preview email
      // todo: add button for sending email to everyone
      // todo: add confirm modal for sending email to everyone
      // todo: make sure it works well on a phone screen
    },
    methods: {
      debounce() {
        if (this.timeout) 
          clearTimeout(this.timeout); 

        this.timeout = setTimeout(() => {
          this.compiledMarkdown()
        }, 500); // delay
      },
      compiledMarkdown() {
        // Make an api call to get the markdown
        this.saveState = false;
        this.loading = true;
        this.error = false;
        axios.post('/emails/newsletter/preview', {
          body_text: this.body_text,
          image_url: this.image_url,
          button_url: this.button_url,
          button_text: this.button_text,
          subject: this.subject,
        }).then(response => {
          this.markdown = response.data;
          this.save();
        });
      },
      save() {
        axios.post('/emails/newsletter/store', {
          body_text: this.body_text,
          image_url: this.image_url,
          button_url: this.button_url,
          button_text: this.button_text,
          preview_email_address: this.preview_email_address,
          subject: this.subject,
        }).then(() => {
          this.saved = true;
          this.error = false;
        }).catch(error => {
          this.error = true;
          this.saved = false;
          console.log(error);
        }).finally(() => {
          this.loading = false;
        });
      },
      get() {
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
        axios.post('/emails/newsletter/preview', {
          preview_email_address: this.preview_email_address,
        }).then(response => {
          console.log(response);
        });
      },
      update() {
        this.debounce()
      }
    }
  }
</script>
