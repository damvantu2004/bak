# Bakya - Hệ thống bán bánh trực tuyến

## Tổng quan dự án
Bakya là một hệ thống thương mại điện tử chuyên về bán bánh và các sản phẩm làm bánh. Dự án được xây dựng bằng PHP thuần với mô hình MVC và sử dụng MySQL làm cơ sở dữ liệu.

## Cấu trúc thư mục
```
bakya/
├── Application/              # Chứa mã nguồn chính của ứng dụng
│   ├── Controllers/          # Các controller xử lý logic business
│   │   ├── Admin/            # Controller cho phần quản trị
│   │   ├── BaseController.php # Controller cơ sở
│   │   └── ...               # Các controller khác
│   ├── Models/               # Các model thao tác với database
│   │   ├── BaseModel.php     # Model cơ sở
│   │   └── ...               # Các model khác
│   └── Views/                # Các file giao diện người dùng
├── Core/                     # Các lớp cơ sở và hạ tầng
│   ├── Database.php          # Lớp kết nối cơ sở dữ liệu
│   ├── UploadFile.php        # Xử lý upload file
│   └── bakya.sql             # File SQL tạo cơ sở dữ liệu
├── Helper/                   # Các lớp trợ giúp
│   ├── Common.php            # Hàm tiện ích chung
│   ├── Paginator.php         # Xử lý phân trang
│   └── ...                   # Các helper khác
├── public/                   # Tài nguyên tĩnh (CSS, JS, images)
└── index.php                 # File bootstrap, điểm khởi đầu của ứng dụng
```

## Cấu trúc cơ sở dữ liệu
Cơ sở dữ liệu Bakya gồm 11 bảng được phân tích chi tiết như sau:

### 1. Bảng `account`
- **Mục đích**: Lưu trữ thông tin người dùng (khách hàng và quản trị viên)
- **Khóa chính**: `id` (int, tự động tăng)
- **Các trường quan trọng**:
  - `fname`, `lname`: Họ và tên người dùng
  - `email`, `phone`: Thông tin liên hệ (có ràng buộc UNIQUE)
  - `password`: Mật khẩu đã được mã hóa
  - `remember_token`: Token để duy trì phiên đăng nhập
  - `role`: Phân quyền người dùng ('customer', 'admin')
  - `status`: Trạng thái tài khoản (1-hoạt động, 0-bị khóa)
- **Quan hệ với bảng khác**:
  - Liên kết 1-n với `order` (một tài khoản có thể có nhiều đơn hàng)
  - Liên kết 1-n với `review` (một tài khoản có thể có nhiều đánh giá)
  - Liên kết 1-n với `blog` (một tài khoản có thể viết nhiều bài blog)
  - Liên kết 1-n với `comment` (một tài khoản có thể viết nhiều bình luận)

### 2. Bảng `product`
- **Mục đích**: Lưu trữ thông tin sản phẩm
- **Khóa chính**: `id` (int, tự động tăng)
- **Các trường quan trọng**:
  - `name`: Tên sản phẩm
  - `image`: Đường dẫn hình ảnh sản phẩm
  - `price`: Giá gốc
  - `sale_price`: Giá khuyến mãi (mặc định là 0)
  - `description`: Mô tả chi tiết
  - `origin`: Xuất xứ sản phẩm
  - `quantity`: Số lượng trong kho
  - `status`: Trạng thái hiển thị (1-hiển thị, 0-ẩn)
  - `category_id`: Liên kết với bảng category
- **Quan hệ với bảng khác**:
  - Liên kết n-1 với `category` (nhiều sản phẩm thuộc một danh mục)
  - Liên kết 1-n với `review` (một sản phẩm có thể có nhiều đánh giá)
  - Liên kết 1-n với `order_detail` (một sản phẩm có thể xuất hiện trong nhiều chi tiết đơn hàng)

### 3. Bảng `category`
- **Mục đích**: Phân loại sản phẩm theo nhóm
- **Khóa chính**: `id` (int, tự động tăng)
- **Các trường quan trọng**:
  - `name`: Tên danh mục (có ràng buộc UNIQUE)
  - `status`: Trạng thái hiển thị (1-hiển thị, 0-ẩn)
  - `priority`: Thứ tự ưu tiên hiển thị
- **Quan hệ với bảng khác**:
  - Liên kết 1-n với `product` (một danh mục có thể có nhiều sản phẩm)

### 4. Bảng `order`
- **Mục đích**: Lưu trữ thông tin đơn hàng
- **Khóa chính**: `id` (int, tự động tăng)
- **Các trường quan trọng**:
  - `fname`, `lname`, `email`, `phone`: Thông tin người đặt hàng
  - `province`, `address`: Địa chỉ giao hàng
  - `note`: Ghi chú đơn hàng
  - `delivery`: Phương thức vận chuyển
  - `payment`: Phương thức thanh toán
  - `status`: Trạng thái đơn hàng (1-đang xử lý, 0-đã giao, 2-đang giao, 3-đã hủy)
  - `account_id`: Liên kết với tài khoản người dùng
  - `coupon`: Giá trị mã giảm giá đã áp dụng
- **Quan hệ với bảng khác**:
  - Liên kết n-1 với `account` (nhiều đơn hàng thuộc về một tài khoản)
  - Liên kết 1-n với `order_detail` (một đơn hàng có thể có nhiều chi tiết đơn hàng)

### 5. Bảng `order_detail`
- **Mục đích**: Lưu trữ chi tiết sản phẩm trong đơn hàng
- **Khóa chính**: Kết hợp từ `order_id` và `product_id` (không có cột `id` riêng biệt)
- **Các trường quan trọng**:
  - `order_id`: Liên kết với đơn hàng
  - `product_id`: Liên kết với sản phẩm
  - `quantity`: Số lượng sản phẩm đặt mua
  - `price`: Tổng giá tiền của sản phẩm (số lượng * đơn giá)
- **Quan hệ với bảng khác**:
  - Liên kết n-1 với `order` (nhiều chi tiết đơn hàng thuộc về một đơn hàng)
  - Liên kết n-1 với `product` (nhiều chi tiết đơn hàng có thể liên kết đến cùng một sản phẩm)
- **Lưu ý quan trọng**: Bảng này không có cột `id` riêng biệt, sử dụng khóa kết hợp từ `order_id` và `product_id`

### 6. Bảng `banner`
- **Mục đích**: Quản lý banner hiển thị trên các trang web
- **Khóa chính**: `id` (int, tự động tăng)
- **Các trường quan trọng**:
  - `name`: Tên banner
  - `image`: Đường dẫn hình ảnh
  - `site`: Vị trí hiển thị (trang chủ, sản phẩm, giỏ hàng, v.v)
  - `description`: Mô tả banner
  - `status`: Trạng thái hiển thị (1-hiển thị, 0-ẩn)
  - `priority`: Thứ tự ưu tiên hiển thị

### 7. Bảng `coupon`
- **Mục đích**: Quản lý mã giảm giá
- **Khóa chính**: `id` (varchar, mã coupon - khác với các bảng khác)
- **Các trường quan trọng**:
  - `coupon_value`: Giá trị giảm giá (tỷ lệ phần trăm)
  - `used_times`: Số lần có thể sử dụng
  - `status`: Trạng thái (1-hoạt động, 0-hết hạn)
- **Lưu ý**: Khóa chính của bảng này là chuỗi văn bản (VARCHAR) thay vì số tự động tăng như các bảng khác

### 8. Bảng `review`
- **Mục đích**: Lưu trữ đánh giá sản phẩm của người dùng
- **Khóa chính**: `id` (int, tự động tăng)
- **Các trường quan trọng**:
  - `rating`: Số sao đánh giá (1-5)
  - `content`: Nội dung đánh giá
  - `product_id`: Liên kết với sản phẩm
  - `account_id`: Liên kết với tài khoản người đánh giá
- **Quan hệ với bảng khác**:
  - Liên kết n-1 với `product` (nhiều đánh giá cho một sản phẩm)
  - Liên kết n-1 với `account` (nhiều đánh giá từ một người dùng)

### 9. Bảng `contact`
- **Mục đích**: Lưu trữ thông tin liên hệ từ khách hàng
- **Khóa chính**: `id` (int, tự động tăng)
- **Các trường quan trọng**:
  - `message`: Nội dung tin nhắn
  - `name`: Tên người liên hệ
  - `email`: Email liên hệ
  - `phone`: Số điện thoại

### 10. Bảng `blog`
- **Mục đích**: Lưu trữ bài viết blog
- **Khóa chính**: `id` (int, tự động tăng)
- **Các trường quan trọng**:
  - `title`: Tiêu đề bài viết
  - `image`: Hình ảnh của bài viết
  - `summary`: Tóm tắt bài viết
  - `description`: Nội dung chi tiết
  - `status`: Trạng thái hiển thị (1-hiển thị, 0-ẩn)
  - `account_id`: Liên kết với tài khoản tác giả
- **Quan hệ với bảng khác**:
  - Liên kết n-1 với `account` (nhiều bài viết của một tác giả)
  - Liên kết 1-n với `comment` (một bài viết có thể có nhiều bình luận)

### 11. Bảng `comment`
- **Mục đích**: Lưu trữ bình luận cho các bài blog
- **Khóa chính**: `id` (int, tự động tăng)
- **Các trường quan trọng**:
  - `name`: Tên người bình luận
  - `email`: Email người bình luận
  - `content`: Nội dung bình luận
  - `blog_id`: Liên kết với bài blog
  - `account_id`: Liên kết với tài khoản người bình luận
- **Quan hệ với bảng khác**:
  - Liên kết n-1 với `blog` (nhiều bình luận cho một bài viết)
  - Liên kết n-1 với `account` (nhiều bình luận từ một người dùng)

## Các tính năng chính

### Người dùng
- Đăng ký, đăng nhập, quản lý tài khoản
- Xem danh sách sản phẩm theo danh mục
- Tìm kiếm sản phẩm
- Thêm sản phẩm vào giỏ hàng, thanh toán
- Sử dụng mã giảm giá
- Đánh giá sản phẩm
- Theo dõi đơn hàng đã đặt
- Gửi thông tin liên hệ
- Xem và bình luận bài viết blog

### Quản trị viên
- Quản lý sản phẩm (thêm, sửa, xóa)
- Quản lý danh mục
- Quản lý đơn hàng và cập nhật trạng thái
- Quản lý người dùng
- Quản lý mã giảm giá
- Quản lý banner
- Quản lý bài viết blog
- Xem và phản hồi thông tin liên hệ
- Xem thống kê doanh thu

## Cài đặt và triển khai

### Yêu cầu hệ thống
- PHP 7.0 trở lên
- MySQL 5.7 trở lên
- Web server (Apache/Nginx)

### Các bước cài đặt
1. **Chuẩn bị môi trường**
   - Cài đặt XAMPP/WAMP/LAMP tùy theo hệ điều hành

2. **Clone/Download mã nguồn**
   - Đặt mã nguồn vào thư mục webroot (htdocs)

3. **Tạo cơ sở dữ liệu**
   - Tạo database có tên "bakya"
   - Import file `Core/bakya.sql` vào database

4. **Cấu hình kết nối database**
   - Mở file `Core/Database.php` và cấu hình thông tin kết nối:
     - Host
     - Username
     - Password
     - Database name

5. **Cấu hình đường dẫn**
   - Điều chỉnh đường dẫn (base URL) nếu cần thiết

6. **Khởi chạy ứng dụng**
   - Truy cập http://localhost/bakya (hoặc URL tương ứng)
   - Đăng nhập với tài khoản admin mặc định:
     - Email: admin@example.com
     - Password: 12345678

## Kiến trúc phần mềm
Dự án áp dụng mô hình MVC (Model-View-Controller):

- **Model**: Xử lý tương tác với database và thực hiện các thao tác dữ liệu
- **View**: Hiển thị dữ liệu và giao diện người dùng
- **Controller**: Điều khiển luồng xử lý, nhận request và trả về response

Với cấu trúc Front Controller, mọi request đều đi qua file index.php, được phân tích và điều hướng đến controller và action tương ứng.

## Các lưu ý quan trọng
- Bảng `order_detail` không có cột ID, sử dụng khóa chính kết hợp (order_id, product_id) - điều này gây ra lỗi với BaseModel
- Bảng `coupon` sử dụng khóa chính là VARCHAR thay vì INT như các bảng khác
- BaseModel có một số giả định về cấu trúc các bảng:
  - Giả định mọi bảng đều có cột ID kiểu INT
  - Cần điều chỉnh các phương thức khi làm việc với bảng đặc biệt như order_detail và coupon
- Cơ chế phân quyền dựa trên trường role trong bảng account
- Truy cập phần quản trị qua URL: index.php?module=admin

## Liên hệ và hỗ trợ
Nếu có vấn đề hoặc câu hỏi, vui lòng liên hệ qua email hoặc tạo issue trên repository. 