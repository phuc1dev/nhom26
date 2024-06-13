# Quản Lý Phòng Máy Tính - Nhóm 26

Đây là một ứng dụng web giúp quản lý phòng máy tính. Ứng dụng này được phát triển bởi Nhóm 26 với mục tiêu cung cấp một giải pháp hiệu quả và tiện lợi để quản lý các phòng máy tính.

Ứng dụng này cung cấp một giao diện trực quan và dễ sử dụng, giúp người dùng dễ dàng theo dõi tình trạng của từng máy tính trong phòng, cũng như cập nhật thông tin về phòng máy và máy tính. Ngoài ra, ứng dụng còn cung cấp các chức năng như xem thông tin chi tiết về từng phòng máy, theo dõi tình trạng của từng máy tính trong phòng, cập nhật thông tin về phòng máy và máy tính, và nhiều hơn nữa.

Ứng dụng được xây dựng dựa trên ngôn ngữ lập trình PHP, với sự hỗ trợ của các thư viện và công nghệ như HTML, CSS, JavaScript, và SQL. Đặc biệt, ứng dụng sử dụng thư viện Moment.js để xử lý và hiển thị thời gian, và thư viện Toastr.js để hiển thị thông báo cho người dùng.

Để cài đặt và chạy ứng dụng này trên máy cục bộ, hãy tham khảo phần [Cài Đặt](#cài-đặt) dưới đây.

## Cài Đặt
Để cài đặt và chạy ứng dụng này trên máy cục bộ, hãy thực hiện các bước sau:

1. Cài đặt XAMPP từ [đây](https://www.apachefriends.org/index.html).

2. Clone repo từ GitHub:

```sh
git clone https://github.com/phuc1dev/nhom26.git
```

3. Di chuyển thư mục dự án vào thư mục htdocs trong thư mục cài đặt XAMPP.

4. Khởi động XAMPP và bật Apache và MySQL.

5. Truy cập http://localhost/phpmyadmin trên trình duyệt, tạo một cơ sở dữ liệu mới và sau đó nhập tệp nhom26.sql để tạo cấu trúc và dữ liệu cho cơ sở dữ liệu.

6. Mở tệp ```/init/config.php``` và chỉnh sửa thông tin cấu hình cơ sở dữ liệu để phù hợp với cài đặt cục bộ của bạn. Thông tin cần chỉnh sửa bao gồm tên máy chủ (thường là localhost), tên cơ sở dữ liệu (tên của cơ sở dữ liệu bạn vừa tạo), tên người dùng và mật khẩu.

7. Truy cập http://localhost/your-project trên trình duyệt để xem ứng dụng.


## Sử Dụng
Ứng dụng web này giúp quản lý phòng máy tính. Bạn có thể thực hiện các chức năng sau:

 * Xem thông tin chi tiết về từng phòng máy.
 * Theo dõi tình trạng của từng máy tính trong phòng.
 * Cập nhật thông tin về phòng máy và máy tính.
