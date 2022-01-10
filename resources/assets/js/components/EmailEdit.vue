<template>
  <div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
      <div class="" uk-grid>
        <div class="uk-width-1-2@s uk-card uk-card-default uk-card-body">
          <h3 class="uk-card-title">Edit News Letter Email</h3>
          <div class="uk-width-1-1@s uk-margin">
            <label class="uk-form-label uk-heading-bullet" for="email_subject">Subject</label>
            <div class="uk-form-controls">
              <input type="text" class="uk-input" name="email_subject" v-model="email_subject" @input="update">
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
              <textarea class="uk-textarea" rows="10" v-model="body" @input="update"></textarea>
            </div>
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
        body: `# New Year, New Business Phone Number!\n\nI hope you all had a wonderful holiday season! My staff and I look forward to seeing you back in the pool very soon! Before we dive into 2022, I wanted to let you know we are starting off the new year with a new phone number! The Swim School now has an official business phone line and the new number is **Phone Number**.\n\nYou can reach us by either calling this number, sending a message through the “Contact Us” section of the website, or sending an email to **Email**. The previous phone number is no longer in service, so please update our contact details. In regards to our winter swim programs, private lessons for the month of January are already open for registration through the website. The first weekday session of group lessons and swim club opens for registration tomorrow Monday, January 3rd and the first weekend session of group lessons opens for registration Monday, January 10th.`,
        button_url: "https://theswimschoolfl.com/lessons",
        button_text: "Button Text",
        email_subject: "Email Subject",
        timeout: null,
        markdown: "",
      }
    },
    created() {
      this.update();
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
        axios.post('/emails/newsletter/preview', {
          body: this.body,
          image_url: this.image_url,
          button_url: this.button_url,
          button_text: this.button_text,
          email_subject: this.email_subject,
        }).then(response => {
          this.markdown = response.data;
        });

      },
      update() {
        this.debounce()
      }
    }
  }
</script>
