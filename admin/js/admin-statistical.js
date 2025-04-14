// var xValuesBar1 = ["Tôn giáo tâm linh", "Triết học khoa học", "Kinh tế chính trị", "Văn hóa nghệ thuật", "Tâm lý kỹ năng", "Kiến thức tổng hợp", "Văn phòng phẩm"];
// var yValuesBar1 = [10, 17, 5, 20, 15, 7, 16];
// var barColors = ["#FF436B", "#FFCD56", "#4BC0C0", "#9966FF", "#22BA70", "#D73038", "#079BFE"];
// var yAxisLabel1 = "nghìn sản phẩm";

// var chart1 = new Chart("barChart1", {
//     type: "bar",
//     data: {
//         labels: xValuesBar1,
//         datasets: [{
//             backgroundColor: barColors,
//             data: yValuesBar1
//         }]
//     },
//     options: {
//         legend: { display: false },
//         scales: {
//             yAxes: [{
//                 scaleLabel: {
//                     display: true,
//                     labelString: yAxisLabel1
//                 }
//             }]
//         }
//     }
// });

// // Biểu đồ cột 2
// var xValuesBar2 = ["Tôn giáo tâm linh", "Triết học khoa học", "Kinh tế chính trị", "Văn hóa nghệ thuật", "Tâm lý kỹ năng", "Kiến thức tổng hợp", "Văn phòng phẩm"];
// var yValuesBar2 = [8, 3, 15, 12, 7, 19, 10];
// var yAxisLabel2 = "nghìn sản phẩm";

// var chart2 = new Chart("barChart2", {
//     type: "bar",
//     data: {
//         labels: xValuesBar2,
//         datasets: [{
//             backgroundColor: barColors,
//             data: yValuesBar2
//         }]
//     },
//     options: {
//         legend: { display: false },
//         scales: {
//             yAxes: [{
//                 scaleLabel: {
//                     display: true,
//                     labelString: yAxisLabel2
//                 }
//             }]
//         }
//     }
// });

// // pie Charts
// var yValuesPie1 = [10000000, 17000000, 5000000, 23000000, 15000000, 7000000, 16000000];

// new Chart("pieChart", {
//     type: "pie",
//     data: {
//         labels: xValuesBar1,
//         datasets: [{
//             backgroundColor: barColors,
//             data: yValuesPie1
//         }]
//     },
//     options: {

//     }
// });

// // Function to switch between charts
// function switchCharts(panelIndex) {
//     if (panelIndex === 0) {
//         yAxisLabel1 = "nghìn sản phẩm"; // Update yAxisLabel for chart 1
//         chart1.destroy();
//         chart2.destroy();

//         chart1 = new Chart("barChart1", {
//             type: "bar",
//             data: {
//                 labels: xValuesBar1,
//                 datasets: [{
//                     backgroundColor: barColors,
//                     data: yValuesBar1
//                 }]
//             },
//             options: {
//                 legend: { display: false },
//                 scales: {
//                     yAxes: [{
//                         scaleLabel: {
//                             display: true,
//                             labelString: yAxisLabel1
//                         }
//                     }]
//                 }
//             }
//         });

//         document.getElementById("t1").classList.add("show");
//         document.getElementById("t1").classList.remove("hide");
//         document.getElementById("t2").classList.remove("show");
//         document.getElementById("t2").classList.add("hide");
//     } else if (panelIndex === 1) {
//         yAxisLabel2 = "nghìn sản phẩm"; // Update yAxisLabel for chart 2
//         chart1.destroy();
//         chart2.destroy();

//         chart2 = new Chart("barChart2", {
//             type: "bar",
//             data: {
//                 labels: xValuesBar2,
//                 datasets: [{
//                     backgroundColor: barColors,
//                     data: yValuesBar2
//                 }]
//             },
//             options: {
//                 legend: { display: false },
//                 scales: {
//                     yAxes: [{
//                         scaleLabel: {
//                             display: true,
//                             labelString: yAxisLabel2
//                         }
//                     }]
//                 }
//             }
//         });

//         document.getElementById("t1").classList.remove("show");
//         document.getElementById("t1").classList.add("hide");
//         document.getElementById("t2").classList.add("show");
//         document.getElementById("t2").classList.remove("hide");
//     }
// }

// // Event listener for the bar chart select
// document.getElementById("selectBar").addEventListener("change", function () {
//     if (this.value === "t1") {
//         switchCharts(0);
//     } else if (this.value === "t2") {
//         switchCharts(1);
//     }
// });

// // Event listener for the pie chart select
// document.getElementById("selectPie").addEventListener("change", function () {
//     if (this.value === "t1") {
//         switchCharts(0);
//     } else if (this.value === "t2") {
//         switchCharts(1);
//     }
// });


//////////////////////////////////////////////////
var barColors = ["#FF436B", "#FFCD56", "#4BC0C0", "#9966FF", "#22BA70", "#D73038", "#079BFE"];
var xValuesBar1 = ["Tôn giáo tâm linh", "Triết học khoa học", "Kinh tế chính trị", "Văn hóa nghệ thuật", "Tâm lý kỹ năng", "Kiến thức tổng hợp", "Văn phòng phẩm"];
// Bar Charts
var yValuesBar1 = [10, 17, 5, 20, 15, 7, 16];
var yValuesBar2 = [8, 3, 15, 12, 7, 19, 10];
var yValuesBar3 = [3, 9, 10, 10, 7, 14, 8];


new Chart("barChart1", {
    type: "bar",
    data: {
        labels: xValuesBar1,
        datasets: [{
            backgroundColor: barColors,
            data: yValuesBar1
        }]
    },
    options: {
        legend: { display: false },

    }
});


new Chart("barChart2", {
    type: "bar",
    data: {
        labels: xValuesBar1,
        datasets: [{
            backgroundColor: barColors,
            data: yValuesBar2
        }]
    },
    options: {
        legend: { display: false },

    }
});

new Chart("barChart3", {
    type: "bar",
    data: {
        labels: xValuesBar1,
        datasets: [{
            backgroundColor: barColors,
            data: yValuesBar3
        }]
    },
    options: {
        legend: { display: false },

    }
});

// pie Charts
var yValuesPie1 = [10000000, 17000000, 5000000, 23000000, 15000000, 7000000, 16000000];
var yValuesPie2 = [12000000, 7000000, 15000000, 4000000, 8000000, 12000000, 19000000];
var yValuesPie3 = [6000000, 14000000, 7500000, 8000000, 4000000, 6000000, 8500000];

new Chart("pieChart1", {
    type: "pie",
    data: {
        labels: xValuesBar1,
        datasets: [{
            backgroundColor: barColors,
            data: yValuesPie1
        }]
    },
    options: {

    }
});

new Chart("pieChart2", {
    type: "pie",
    data: {
        labels: xValuesBar1,
        datasets: [{
            backgroundColor: barColors,
            data: yValuesPie2
        }]
    },
    options: {

    }
});

new Chart("pieChart3", {
    type: "pie",
    data: {
        labels: xValuesBar1,
        datasets: [{
            backgroundColor: barColors,
            data: yValuesPie3
        }]
    },
    options: {

    }
});


//////////////////////////////////////////////
var currentChart = 't1';

document.querySelector('#select').addEventListener('change', function() {
    document.querySelectorAll('.' + currentChart).forEach(element => {
        element.classList.toggle('hide');
    });
    var value = document.querySelector('#select').value;
    document.querySelectorAll('.' + value).forEach(element => {
        element.classList.toggle('hide');
    });
    currentChart = value;
})

// change year
    function changeYear() {
        var selectedYear = document.getElementById("year").value;

        // Thực hiện các bước cập nhật nội dung cho năm được chọn
        if (selectedYear === "2022") {
            updateContentForYear2022();
        } else if (selectedYear === "2023") {
            updateContentForYear2023();
        }
        // Nếu muốn thêm xử lý cho các năm khác, bạn có thể mở rộng ở đây
    }

    function updateContentForYear2022() {
        // Thực hiện cập nhật nội dung cho năm 2022
        // Ví dụ: thay đổi dữ liệu biểu đồ, bảng thống kê, vv.
        // Ví dụ đơn giản: thay đổi tiêu đề hóa đơn
        document.querySelector('.input-section h1').textContent = 'Thống Kê Hóa Đơn 2022';
        var barColors = ["#FF436B", "#FFCD56", "#4BC0C0", "#9966FF", "#22BA70", "#D73038", "#079BFE"];
        var xValuesBar1 = ["Tôn giáo tâm linh", "Triết học khoa học", "Kinh tế chính trị", "Văn hóa nghệ thuật", "Tâm lý kỹ năng", "Kiến thức tổng hợp", "Văn phòng phẩm"];
        // Bar Charts
        var yValuesBar1 = [5, 11, 5, 10, 10, 7, 4];
        var yValuesBar2 = [2, 3, 4, 5, 6, 7, 10];
        var yValuesBar3 = [3, 9, 14, 8, 7, 10, 8];


        new Chart("barChart1", {
            type: "bar",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesBar1
                }]
            },
            options: {
                legend: { display: false },

            }
        });


        new Chart("barChart2", {
            type: "bar",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesBar2
                }]
            },
            options: {
                legend: { display: false },

            }
        });

        new Chart("barChart3", {
            type: "bar",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesBar3
                }]
            },
            options: {
                legend: { display: false },

            }
        });

        // pie Charts
        var yValuesPie1 = [10000000, 17000000, 5000000, 23000000, 15000000, 7000000, 16000000];
        var yValuesPie2 = [12000000, 7000000, 15000000, 4000000, 8000000, 12000000, 19000000];
        var yValuesPie3 = [6000000, 14000000, 7500000, 8000000, 4000000, 6000000, 8500000];

        new Chart("pieChart1", {
            type: "pie",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesPie1
                }]
            },
            options: {

            }
        });

        new Chart("pieChart2", {
            type: "pie",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesPie2
                }]
            },
            options: {

            }
        });

        new Chart("pieChart3", {
            type: "pie",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesPie3
                }]
            },
            options: {

            }
        });
        // Thêm các thay đổi khác cho năm 2022 tại đây
    }

    function updateContentForYear2023() {
        // Thực hiện cập nhật nội dung cho năm 2023
        // Ví dụ: khôi phục dữ liệu mặc định
        // Ví dụ đơn giản: khôi phục tiêu đề hóa đơn về trạng thái ban đầu
        document.querySelector('.input-section h1').textContent = 'Thống Kê Hóa Đơn';
        var barColors = ["#FF436B", "#FFCD56", "#4BC0C0", "#9966FF", "#22BA70", "#D73038", "#079BFE"];
        var xValuesBar1 = ["Tôn giáo tâm linh", "Triết học khoa học", "Kinh tế chính trị", "Văn hóa nghệ thuật", "Tâm lý kỹ năng", "Kiến thức tổng hợp", "Văn phòng phẩm"];
        // Bar Charts
        var yValuesBar1 = [10, 17, 5, 20, 15, 7, 16];
        var yValuesBar2 = [8, 3, 15, 12, 7, 19, 10];
        var yValuesBar3 = [3, 9, 10, 10, 7, 14, 8];


        new Chart("barChart1", {
            type: "bar",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesBar1
                }]
            },
            options: {
                legend: { display: false },

            }
        });


        new Chart("barChart2", {
            type: "bar",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesBar2
                }]
            },
            options: {
                legend: { display: false },

            }
        });

        new Chart("barChart3", {
            type: "bar",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesBar3
                }]
            },
            options: {
                legend: { display: false },

            }
        });

        // pie Charts
        var yValuesPie1 = [10000000, 17000000, 5000000, 23000000, 15000000, 7000000, 16000000];
        var yValuesPie2 = [12000000, 7000000, 15000000, 4000000, 8000000, 12000000, 19000000];
        var yValuesPie3 = [6000000, 14000000, 7500000, 8000000, 4000000, 6000000, 8500000];

        new Chart("pieChart1", {
            type: "pie",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesPie1
                }]
            },
            options: {

            }
        });

        new Chart("pieChart2", {
            type: "pie",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesPie2
                }]
            },
            options: {

            }
        });

        new Chart("pieChart3", {
            type: "pie",
            data: {
                labels: xValuesBar1,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValuesPie3
                }]
            },
            options: {

            }
        });
        // Thêm các thay đổi khác cho năm 2023 tại đây
    }
