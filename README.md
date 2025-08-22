# 🎨 ScodeTheme - WordPress Theme Hiện Đại

**ScodeTheme** là một theme WordPress hiện đại, được thiết kế lấy cảm hứng từ các website e-commerce hàng đầu như MI VIETNAM.VN. Theme được tối ưu hóa cho WooCommerce với giao diện sạch sẽ, dễ tùy chỉnh và hiệu suất cao.

## ✨ Tính năng chính

- 🎯 **Thiết kế hiện đại** - Lấy cảm hứng từ MI VIETNAM.VN
- 📱 **Responsive hoàn toàn** - Tối ưu cho mọi thiết bị
- 🛒 **WooCommerce Ready** - Tích hợp sẵn giỏ hàng, tài khoản
- 🌙 **Dark Mode** - Tự động theo system preference
- ⚡ **Performance cao** - CSS Variables, animations mượt mà
- 🔧 **Dễ tùy chỉnh** - Nhiều tùy chọn trong Customizer

## 🚀 Cài đặt

1. **Tải theme** về thư mục `wp-content/themes/`
2. **Kích hoạt theme** trong WordPress Admin
3. **Tùy chỉnh** qua Appearance > Customize

## 🎨 Tùy chỉnh dễ dàng

### 1. Thay đổi màu sắc

Vào **Appearance > Customize > ScodeTheme Options**:

- **Primary Color (Orange)**: Màu chính cho buttons và highlights
- **Secondary Color (Blue)**: Màu phụ cho links và accents

### 2. Tùy chỉnh Hero Section

- **Hero Title**: Tiêu đề chính
- **Hero Description**: Mô tả phụ
- **Hero Button Text**: Text nút CTA
- **Hero Button URL**: Link nút CTA

### 3. Tùy chỉnh Product Grid

- **Product Grid Columns**: Số cột hiển thị sản phẩm (2-5 cột)
- **Show Category Banners**: Hiển thị/ẩn banner danh mục

### 4. Tùy chỉnh Footer

- **Footer Copyright Text**: Text copyright

## 🔧 CSS Variables - Dễ dàng thay đổi

Theme sử dụng CSS Variables để dễ dàng tùy chỉnh:

```css
:root {
    --primary-color: #ff6b35;          /* Màu cam chính */
    --secondary-color: #1e3a8a;        /* Màu xanh phụ */
    --accent-color: #f59e0b;           /* Màu vàng accent */
    --product-grid-columns: 4;         /* Số cột sản phẩm */
    --product-card-height: 400px;      /* Chiều cao card sản phẩm */
    --product-image-height: 280px;     /* Chiều cao ảnh sản phẩm */
    --border-radius: 12px;             /* Bo góc */
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1); /* Bóng đổ */
}
```

### Thay đổi nhanh:

- **Màu sắc**: Cập nhật giá trị `--primary-color`, `--secondary-color`
- **Grid**: Thay đổi `--product-grid-columns`
- **Kích thước**: Điều chỉnh `--product-card-height`, `--product-image-height`
- **Bo góc**: Thay đổi `--border-radius`
- **Bóng đổ**: Cập nhật `--shadow-*`

## 📱 Responsive Design

Theme tự động điều chỉnh layout theo kích thước màn hình:

- **Desktop (>1200px)**: 4-5 cột sản phẩm
- **Tablet (768-1200px)**: 3 cột sản phẩm
- **Mobile (480-768px)**: 2 cột sản phẩm
- **Small Mobile (<480px)**: 1 cột sản phẩm

## 🎯 Widget Areas

Theme cung cấp nhiều widget areas:

- **Sidebar**: Widget bên phải
- **Hero Section**: Nội dung hero section
- **Category Banners**: Banner danh mục
- **Footer Widget Areas**: 3 khu vực footer

## 🛒 WooCommerce Features

- ✅ Tích hợp sẵn giỏ hàng
- ✅ Tài khoản người dùng
- ✅ Tìm kiếm sản phẩm
- ✅ Grid sản phẩm responsive
- ✅ Sale badges
- ✅ Add to cart buttons

## 📁 Cấu trúc theme

```
scode-theme/
├── style.css          # CSS chính với CSS variables
├── index.php          # Template chính
├── header.php         # Header với navigation
├── footer.php         # Footer với widgets
├── sidebar.php        # Sidebar với default content
├── functions.php      # PHP functions và hooks
└── README.md          # Hướng dẫn này
```

## 🎨 Tùy chỉnh nâng cao

### 1. Thay đổi fonts

Cập nhật trong `style.css`:

```css
:root {
    --font-primary: 'Your Font', sans-serif;
    --font-mono: 'Your Mono Font', monospace;
}
```

### 2. Thay đổi container width

```css
:root {
    --container-max-width: 1600px; /* Rộng hơn */
}
```

### 3. Thay đổi header height

```css
:root {
    --header-height: 90px; /* Cao hơn */
}
```

### 4. Tùy chỉnh animations

```css
/* Thay đổi tốc độ animation */
.fade-in {
    animation: fadeIn 1s ease-out; /* Chậm hơn */
}

.slide-in {
    animation: slideIn 0.8s ease-out; /* Chậm hơn */
}
```

## 🔍 Troubleshooting

### Theme không hiển thị đúng?

1. **Xóa cache** của website
2. **Kiểm tra CSS** có bị conflict không
3. **Kiểm tra plugins** có tương thích không

### WooCommerce không hoạt động?

1. **Kích hoạt WooCommerce plugin**
2. **Kiểm tra WooCommerce pages** đã được tạo
3. **Xóa cache** và refresh

### Responsive không hoạt động?

1. **Kiểm tra viewport meta tag**
2. **Kiểm tra CSS media queries**
3. **Test trên nhiều thiết bị**

## 📞 Hỗ trợ

- **Documentation**: Xem file này
- **Customization**: Sử dụng WordPress Customizer
- **CSS Help**: Kiểm tra CSS variables trong `style.css`

## 🚀 Performance Tips

1. **Sử dụng CSS Variables** thay vì hardcode values
2. **Tối ưu images** với WordPress image sizes
3. **Minify CSS/JS** trong production
4. **Sử dụng CDN** cho fonts và icons

## 📝 Changelog

### Version 1.0.0
- ✅ Theme cơ bản hoàn chỉnh
- ✅ WooCommerce integration
- ✅ Responsive design
- ✅ CSS Variables system
- ✅ Customizer options
- ✅ Vietnamese language support

---

**ScodeTheme** - Theme WordPress hiện đại, dễ tùy chỉnh, tối ưu cho WooCommerce! 🎉
