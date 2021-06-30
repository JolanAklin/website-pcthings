/*MIT License
Copyright (c) 2021 Jolan Aklin and Yohan Zbinden

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "text editor"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

function HeaderImageChanged (event) {
    const selectValue = this.value;
    if(selectValue == 0) {
        return;
    }
    axios.post('/images/'+selectValue).then(function(response) {
        const imagelink = response.data.imageLink;

        var header = document.querySelector('div.background-image');
        header.style.background = "linear-gradient(transparent, var(--color-lighter)), url("+imagelink+") no-repeat center center/cover";
        var headerChild = header.querySelector('img.background-image-child');
        headerChild.src = imagelink;
    });
}

function ThumbnailImageChanged(event) {
    const selectValue = this.value;
    if(selectValue == 0) {
        return;
    }
    axios.post('/images/'+selectValue).then(function(response) {
        const imagelink = response.data.imageLink;

        var thumbnailDisplay = document.querySelector('img.thumbnail-display');
        thumbnailDisplay.src = imagelink;
    });
}

document.querySelectorAll('select.header-image-select').forEach(function(select) {
    select.addEventListener('change', HeaderImageChanged);
    select.dispatchEvent(new Event('change'));
});

document.querySelectorAll('select.thumbnail-image-select').forEach(function(select) {
    select.addEventListener('change', ThumbnailImageChanged);
    select.dispatchEvent(new Event('change'));
})